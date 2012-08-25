JUST BORN, WORKING OUT SOME KINKS

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

Add MySQL support to your application, and write down the credentials and host information.
    
	rhc app cartridge add -a status -c mysql-5.1
    
Add this upstream Status.net quickstart repo

	cd status
	rm php/index.php
	git remote add upstream -m master git://github.com/jasonbrooks/statusnet-openshift-quickstart.git
	git pull -s recursive -X theirs upstream master

Push the repo upstream to OpenShift

	git push        

Head to your application at:

	http://status-$yourdomain.rhcloud.com

You'll find your new Status.net instance in need of configuration. Click the link to the installer and provide the requested information, including the DB info you wrote down when you added the mysql cartridge to your app. When that process is finished, you're all set up, but your config file lives only on the openshift service, not in your repo. 

What's more, the DB values you entered in the installer should be replaced with openshift env variables to ensure your app stays running if/when it moves between machines on the openshift service. There's a config file with the correct values prepopulated, we just have to change its name and push it up to openshift:

	cd status
	mv php/config.bak php/config.php
	git rm php/config.bak
	git add php/config.php
	git commit -a -m "rename config file"
	git push
	
That ought to do it. This step should be handled more elegantly, but I haven't figured it out yet. Status.net wants to build the config.php file itself, and it won't accept the openshift env variables in the web form (they're ungainly to enter there, anyhow). However, letting Status.net do it's thing through the web installer script is what's required to get the app to create the first user on the account and to build its db tables.

If you can help me implement the setup through openshift [action hook](https://github.com/openshift/wordpress-example/blob/master/.openshift/action_hooks/deploy) scripts, please do! [This script](https://github.com/jasonbrooks/statusnet-openshift-quickstart/blob/master/php/scripts/setup_status_network.sh), might be a good place to start.

Also, I should modify this setup to ensure that any uploaded files are placed on the correct, persistent openshift data directory. Another to do.

To give your new planet site a web address of its own, add your desired alias:

	rhc app add-alias -a status --alias "$whatever.$mydomain.com"

Then add a cname entry in your domain's dns configuration pointing your alias to $whatever-$yourdomain.rhcloud.com.
