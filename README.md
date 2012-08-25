Status.net on OpenShift
=========================

StatusNet (formerly Laconi.ca) is software using the OStatus protocol (formerly OpenMicroBlogging). StatusNet is a free and open source (AGPL) microblogging platform. It helps people in a community, company or group to exchange messages over the Web. (These are typically short messages, up to 140 characters, but the settings can be changed when using your own install, or a Status.net cloud account.)

The flagship website powered by StatusNet is Identi.ca.

More information can be found at http://status.net/wiki/Main_Page.

Running on OpenShift
--------------------

Create an account at http://openshift.redhat.com/

Create a PHP application

	rhc app create -a status -t php-5.3

Add MySQL support to your application
    
	rhc app cartridge add -a status -c mysql-5.1
    
Add this upstream Status.net quickstart repo

	cd status
	rm php/index.php
	git remote add upstream -m master git://github.com/jasonbrooks/statusnet-openshift-quickstart.git
	git pull -s recursive -X theirs upstream master

Commit changes

	git commit -a -m "first commit"

Then push the repo upstream to OpenShift

	git push        

That's it, you can now checkout your application at:

	http://status-$yourdomain.rhcloud.com

Default Credentials
-------------------
Default Admin Username :: admin
Default Admin Password :: OpenShiftAdmin


To give your new planet site a web address of its own, add your desired alias:

	rhc app add-alias -a status --alias "$whatever.$mydomain.com"

Then add a cname entry in your domain's dns configuration pointing your alias to $whatever-$yourdomain.rhcloud.com.
