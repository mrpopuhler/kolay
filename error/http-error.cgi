#!/usr/bin/perl -w
open STDERR, '>/dev/null';
use strict;
(my $cwd=$0)=~s/^(.*)\\.*?$/$1/;
my ($email_400, $email_500, $unfriendly_error, $redirect_to);
my $main_domain=$ENV{SERVER_NAME};
my @sendmail_path=(qw(/usr/sbin/sendmail -i -odb), "-fwebmaster\@$main_domain");

## Uncomment the below two lines to get emailed regarding the respective
## errors.

#$email_400="webmaster\@$main_domain";
#$email_500="webmaster\@$main_domain";

## If you want people to end up at a particular page for a 404 (Not Found) and
## you've used the $email_400 value above, then uncomment (and edit) the value
## below.
#
#$redirect_to = "/";

## Comment-out the line below to make the script return the actual HTTP status
## code, rather than 200 (success). Don't comment it out if you want all users
## of MSIE (specifically those with "Show Friendly Error Messages" turned on)
## to be able to see your error pages.
#
$unfriendly_error=1;

#
##
## End of configuration
##
## You shouldn't need to edit anything below.
  
sub send_mail($$) {
        my ($to,$message)=@_;
        open(SENDMAIL, "|-", @sendmail_path, $to) or die $!;
        print SENDMAIL $message;
        close SENDMAIL;
}

use CGI;
my $cgi=new CGI;

if($cgi->param("404")) {
	if($redirect_to) {
		# If there's a URL to redirect to, then let's do that.
		# The webmaster could in fact have set this directly in
		# the .htaccess file.
		print $cgi->redirect($redirect_to);
	} elsif(open IFILE, "<", "$cwd/404.html") {
		# Otherwise, we send the default file
		print $cgi->header(-type=>"text/html", -status=>$unfriendly_error?200:404);
		print while <IFILE>;
		close IFILE;
	} else {
		# If we can't find the 404 template, then we really should
		# just give an empty 404 (and hope the server fills it in)
		print $cgi->header(-status=>404);
	}
	if($email_400) {
		send_mail($email_400, <<EOF );
To: $email_400
From: webmaster\@$main_domain
Subject: Missing file
 
A request was received for the file $ENV{HTTP_REFERER}, which does not exist.

EOF
	}
} elsif($cgi->param("500")) {
	if(open IFILE, "<", "$cwd/500.html") {
		print $cgi->header(-type=>"text/html", -status=>$unfriendly_error?200:500);
		print while <IFILE>;
		close IFILE;
	} else {
		# No template? Then just send a 500 and cross fingers.
		# Under no circumstances should this redirect.
		print $cgi->header(-status=>500);
	}
	if($email_500) {
		send_mail($email_500, <<EOF );
To: $email_500
From: webmaster\@$main_domain
Subject: Script error
 
A request was received for the file $ENV{HTTP_REFERER}, which caused an
internal server error.
 
EOF
	}
} else {
	# Last ditch effort: redirect to the home page.
	print $cgi->redirect("/");
}
