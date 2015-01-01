<div class="bg-black">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h1 class="txt-grey">Building this Website</h1>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="content bg-white shadow">
		<h2>Description</h2>
		<p>Most TSA webmaster entries are built using knowledge in HTML, CSS, and maybe a little Javascript or server-side code. At the beginning of this school year, our nationally award winning webmaster team agreed to push the boundries of the webmaster competition and introduce skills and features that no other development team has matched. For the first seven months of this school year, we studied responsive website development, front-end and back-end frameworks, content management systems, database diven web applications, and design patterns to learn how to take this website one step further.</p>
		<p class="text-center"><b>We have no affiliation with the companies, products, and services listed below. The logos only shown are for visual representation.</b></p>
	</div>
	<div class="row content">
		<div class="col-md-8 col-md-offset-2 presentation-block">
			<img src="<?php print DOMAIN_ROOT; ?>/public/image/graphic/twitter-bootstrap.png" />
			<div class="bg-white shadow inner">
				<h3>Responive Design with Twitter Bootstrap</h3>
				<p>From the start we planned to build a responsive website to appeal to mobile users. Our team as a whole decided to use the open source <i><a href="http://getbootstrap.com/">Twitter Bootstrap</a></i> project as the responsive framework for our site. Twitter Boostrap is one of the leading responsive frameworks. We felt it was the best fit for our design requirements and it displayed well on most, if not all, mobile devices.</p>
			</div>
		</div>
	</div>

	<div class="row content">
		<div class="col-md-8 col-md-offset-2 presentation-block">
			<img src="<?php print DOMAIN_ROOT; ?>/public/image/graphic/jquery.png" />
			<div class="bg-white shadow inner">
				<h3>JQuery and Ajax</h3>
				<p>Jquery and Ajax have played a large part in providing a fluid exerience for our users when loading or processing data. When designing the user experience for this site, we decided to build the ajax usage around one central idea: That it will only be used to load non-essential content and process data. The user experience wouldn't be so fluid if a user had to wait a page to load, just to have to wait even longer for an ajax request to fire off and return the main content. That is why most of the ajax was applied to user accounts and administration panels. Both of which require the users to modify database content.</p>
			</div>
		</div>
	</div>

	<div class="row content">
		<div class="col-md-8 col-md-offset-2 presentation-block">
			<img src="<?php print DOMAIN_ROOT; ?>/public/image/graphic/php.png" />
			<div class="bg-white shadow inner">
				<h3>Object Oriented PHP</h3>
				<p>Building this site would be very tedious and repetitive without our favorite server-side language, PHP. Well over half of this site's source code is written in object-oriented coding techniques rather than procedural programming. Using various design patterns, such as MVC, dependency injection, data-mapper, and the factory pattern, we as the developers can quickly write organized, testable, and reuseable code.</p>

				<p>Based off of the <i><a href="http://ellislab.com/codeigniter" target="_blank">CodeIgniter Framework</a></i>, the structure of this application is organized using the Model, View, Controller (MVC) design pattern. Our custom MVC framework my not be as developed as other frameworks, but the knowledge obtained through it's development was well worth the effort.</p>

				<p>The back end framework, in our opinion, is very impressive. For that reason, <b>we have made the code for this site available on GitHub.</b> So you can observe the thousands of lines of code and months of work we put into this website. You can take a look at the code <i><a href="https://github.com/MJayParsons/mshs-tsa-webmaster">HERE</a></i> (this link will only be open from June 8 to June 26th).</p>
			</div>
		</div>
	</div>

	<div class="row content">
		<div class="col-md-8 col-md-offset-2 presentation-block">
			<img src="<?php print DOMAIN_ROOT; ?>/public/image/graphic/mysql.png" />
			<div class="bg-white shadow inner">
				<h3>MySQL Database</h3>
				<p>From the start, we knew we didn't want to create dozens of html pages with identical templates, but different content. That method is far too difficult to maintain and update. A single change in code on one page would lead to mass updates on who knows how many more files! We also didn't want to write thousands of lines of XML to dynamically display pages either.</p>
				<p>This is where our MySQL Database comes into play. Both our main site and our design brief have a administration panel where we can add, update, and delete most of the content across both sites. This means we can use a single template to display the content for many different pages regardless of the content being displayed.</p>
				<p>There are also many other benefits. All of our TSA members have user accounts where they can add their awards and projects. The data from each account is distributed throughout the website. Meaning that if <i>John Doe</i> wins another award, he can add it to his profile so it'll show up on the awards page. Site administrators won't have to do it for him.</p>
				<p>We have found that loading content in from a database is far more productive than relying on cookies and XML files to provide the content we need.</p>
			</div>
		</div>
	</div>

	<div class="row content">
		<div class="col-md-8 col-md-offset-2 presentation-block">
			<img src="<?php print DOMAIN_ROOT; ?>/public/image/graphic/git.png" />
			<div class="bg-white shadow inner">
				<h3>Git and GitHub</h3>
				<p>In past years, our development team ran into three main problems with project collaboration.</p>
				<ol>
					<li>We each had a personal copy of the website. Meaning that everytime a single team member made a change to a file, he/she would then have to distribute that file to all other team members.</li>
					<li>Different versions of a file would often get mixed up from multiple team members changing it.</li>
					<li>FTP is blocked at school. So we couldn't upload our files to a centeral location during team coding sessions. (Then again, uploading untested code to a production server isn't ideal in the first place).</li>
				</ol>
				<p>This is the first year we as a team implemented Git and GitHub into our development phase. Considering this is our largest and most technically advanced application yet, having a central repository and version control system saved us many times. Git solved all of our problems. Each team member could make updates and distribute the changes through git; meaning that each team member had an updated copy at all times. Because Git does not use FTP, we could make updates while at school. Most impressive of all, by adding a couple of cron jobs on our apache server, all Git updates are automatically pushed to our production server.</p>
			</div>
		</div>
	</div>
</div>