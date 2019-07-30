<?php
// Global mode
$db->execute("SET sql_mode = 'ALLOW_INVALID_DATES'");

// CATEGORIES
$db->execute("CREATE TABLE categories(
			id int(11) NOT NULL AUTO_INCREMENT,
			order_id INT(11) NULL DEFAULT NULL,
			name varchar(50) DEFAULT NULL,
			PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// Prepurchase table
$db->execute("CREATE TABLE IF NOT EXISTS prepurchase (
		id INT(11) NOT NULL AUTO_INCREMENT,
		type VARCHAR(50) NOT NULL,
		uid BIGINT(20) NOT NULL,
		json TEXT NOT NULL,
		delivered TINYINT(4) NOT NULL DEFAULT '0',
		extra TEXT NULL,
		timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

$db->execute("INSERT INTO categories(id, name) VALUES
		(1, 'Other')
	");

// LOGS
$db->execute("CREATE TABLE IF NOT EXISTS logs (
		id INT(11) NOT NULL AUTO_INCREMENT,
		uid BIGINT(20) NOT NULL DEFAULT '0',
		action TEXT NOT NULL,
		timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// CREDIT_PACKAGES
$db->execute("CREATE TABLE IF NOT EXISTS credit_packages (
		id int(11) NOT NULL AUTO_INCREMENT,
		title varchar(50) NOT NULL,
		descr text NOT NULL,
		amount int(11) NOT NULL,
		price double NOT NULL,
		currency int(11) NULL,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// CURRENCIES
$db->execute("CREATE TABLE IF NOT EXISTS currencies (
		id int(11) NOT NULL AUTO_INCREMENT,
		cc varchar(3) NOT NULL,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

$db->execute("INSERT INTO currencies (id, cc) VALUES
		(1, 'GBP'),
		(2, 'EUR'),
		(3, 'USD')
	");

// NEWS
$db->execute("CREATE TABLE IF NOT EXISTS news (
		id int(11) NOT NULL AUTO_INCREMENT,
		content text NOT NULL,
		date varchar(50) NOT NULL,
		uid bigint(20) DEFAULT NULL,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

$db->execute("INSERT INTO news (id, content, date, uid) VALUES
		(2, '<p>Welcome to your own donation system. This works as your donation hub. Link your users to this web page after you have configured it correctly to work alongside your servers.</p>', '27 Sep 2014', 0)
	");

// PACKAGES
$db->execute("CREATE TABLE IF NOT EXISTS packages (
		id int(11) NOT NULL AUTO_INCREMENT,
		order_id INT(11) NULL DEFAULT NULL,
		title varchar(50),
		servers TEXT NULL,
		labels text,
		lower_text text,
		actions text,
		currency int(11) DEFAULT '1',
		price double DEFAULT '0',
		credits double DEFAULT '0',
		img varchar(1024),
		permanent int(11),
		rebuyable int(11) DEFAULT '0',
		days int(11) DEFAULT '0',
		custom_price DOUBLE NULL DEFAULT '0',
		custom_price_min DOUBLE NULL DEFAULT NULL,
		non_compatible varchar(1024) DEFAULT '[]',
		upgradeable varchar(1024) DEFAULT '[]',
		hide varchar(1024) DEFAULT '[]',
		no_owned INT(11) NULL DEFAULT '0',
		bought_disable varchar(1024) DEFAULT '[]',
		subscription int(11) NOT NULL DEFAULT '0',
		once int(11) NOT NULL DEFAULT '0',
		category int(11) NOT NULL DEFAULT '1',
		alternative_paypal VARCHAR(50) NULL DEFAULT NULL,
		enabled int(11) DEFAULT '1',
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// PAGES
$db->execute("CREATE TABLE IF NOT EXISTS pages (
		page varchar(50) DEFAULT NULL,
		content text
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

$db->execute("INSERT INTO pages (page, content) VALUES
		('frontpage', '<img src=img/prometheus.png><h2>Example text</h2>This is our community\'s donation system. It is fully automatic and you are able to buy various packages for different servers. They may include anything from ranks to custom perks.<h2>Admin</h2>You can modify this text to your own liking at Admin -&gt; General Settings -&gt; Main page'),
		('tos', '<em>This is an example ToS. Get the server manager to change this to his or her liking!</em><h2>The Panel</h2>\"The service\", \"The panel\", \"This panel\" refers to this donation platform on this specific domain&nbsp;and may not be confused as something else.&nbsp;&nbsp;&nbsp;<h2>Community name</h2>\"Us\", \"We\", \"Our\", \"The community\"&nbsp;all refers to Community name as a group, as a community. We are not responsible for any mistakes you may have made with our service.&nbsp;&nbsp;<h2>Refunds</h2>We do not offer refunds unless we deem you deserve one, as in; If we, the owners, or the service make a mistake we will refund you based upon a descision made there and then. Otherwise refunds are not a thing.&nbsp;&nbsp;'),
		('privacy', '<p><strong>THIS IS AN EXAMPLE PRIVACY POLICY. REPLACE ANYTHING BETWEEN % AND % BEFORE USE. ALTERNATIVELY, USE YOUR OWN.</strong><br><br><br></p><p>This privacy policy governs the manner in which %COMMUNITY% collects, uses, maintains and discloses information collected from users (each, a \"User\") of the %HTTP://COMMUNITY.COM% website (\"Site\"). This privacy policy applies to the Site and all products and services offered by %COMMUNITY%.</p><br><p><strong>Personal identification information</strong><br>We may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users visit our site, register on the site, place an order, and in connection with other activities, services, features or resources we make available on our Site. Users may visit our Site anonymously. We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personally identification information, except that it may prevent them from engaging in certain Site related activities.</p><br><p>This Site uses the Steam Web APIs to retrieve data about users only when those users login using the Steam OpenID provider. The data we store from the Steam Web APIs include 64-bit Steam IDs, Steam Community names, and URLs to Steam Community avatar images.</p><br><p><strong>Web browser cookies</strong><br>Our Site may use \"cookies\" to enhance User experience. Users web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. User may choose to set their web browser to refuse cookies, or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly.</p><p><strong><br></strong></p><p><strong>How we use collected information</strong><br>%COMMUNITY% may collect and use Users personal information for the following purposes:</p><ol><li>To process payments: We may use the information Users provide about themselves when placing an order only to provide service to that order. We do not share this information with outside parties except to the extent necessary to provide the service.</li></ol><br><p><strong>Sharing your personal information</strong><br>We do not sell, trade, or rent Users personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners, trusted affiliates and advertisers for the purposes outlined above.</p><p><strong><br></strong></p><p><strong>Your acceptance of these terms</strong><br>By using this Site you signify your acceptance of this policy. If you do not agree to this policy, please do not use our Site. Your continued use of the Site following the posting of changes to this policy will be deemed your acceptance of those changes.</p><p><strong><br></strong></p><p><strong>Contacting us</strong><br>If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us at: %PLACEHOLDER@EMAIL.COM%<br></p>')
");

// PLAYERS
$db->execute("CREATE TABLE IF NOT EXISTS players (
		id int(11) NOT NULL AUTO_INCREMENT,
		uid bigint(20) DEFAULT NULL,
		name varchar(50) DEFAULT NULL,
		email TEXT NULL DEFAULT NULL,
		avatar TEXT NULL DEFAULT NULL,
		credits double NOT NULL DEFAULT '0',
		admin int(11) NOT NULL DEFAULT '0',
		perm_group INT(11) NULL DEFAULT '0',
		session_token VARCHAR(128) NULL DEFAULT NULL,
		tos_lastread datetime DEFAULT '1000-01-01',
		ip VARCHAR(45) NULL DEFAULT NULL,
		created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// PAYMENTWALL REFIDS
$db->execute("CREATE TABLE paymentwall_refids (
        id INT NOT NULL,
        ref VARCHAR(128) NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE INDEX ref (ref)
    )
    DEFAULT CHARACTER SET utf8   
    COLLATE utf8_general_ci
");

// REQUESTS
$db->execute("CREATE TABLE IF NOT EXISTS requests (
		id int(11) NOT NULL AUTO_INCREMENT,
		error int(11) NOT NULL,
		msg text,
		debug text,
		date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// SERVERS
$db->execute("CREATE TABLE IF NOT EXISTS servers (
		id INT(11) NOT NULL AUTO_INCREMENT,
		order_id INT(11) NULL DEFAULT NULL,
		game VARCHAR(50) NULL DEFAULT NULL,
		ip VARCHAR(50) NULL DEFAULT NULL,
		port VARCHAR(50) NULL DEFAULT NULL,
		rcon TEXT NULL,
		name VARCHAR(128) NOT NULL,
		featured_package INT(11) NOT NULL DEFAULT '0',
		image_link TEXT NULL,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// SETTINGS
$db->execute("CREATE TABLE IF NOT EXISTS settings (
		name varchar(50) NOT NULL,
		value text DEFAULT NULL,
		value2 int(11) NOT NULL DEFAULT '0',
		value3 timestamp NULL DEFAULT NULL,
		PRIMARY KEY (name)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

$db->execute("INSERT INTO settings (name, value, value2, value3) VALUES
		('api_key', '', 0, NULL),
		('api_hash', NULL, 0, NULL),
		('enable_api', NULL, 0, NULL),
		('dashboard_main_cc', NULL, 3, NULL),
		('enable_goal', NULL, 0, NULL),
		('monthly_goal', NULL, 0, NULL),
		('installed', NULL, 0, NULL),
		('paypal_cancel', '', 0, NULL),
		('paypal_email', '', 0, NULL),
		('paypal_ipn', '', 0, NULL),
		('paypal_return', '', 0, NULL),
		('paypal_sandbox', '', 0, NULL),
		('paypal_type', NULL, 1, NULL),
		('sale_enabled', NULL, 0, NULL),
		('sale_enddate', '00/00/0000', 0, NULL),
		('sale_message', '', 0, NULL),
		('sale_percentage', '', 25, NULL),
		('sale_packages', '', 0, NULL),
		('site_copyright', '', 1, NULL),
		('site_title', 'Prometheus', 0, NULL),
		('site_banner', 'img/banner.png', 0, NULL),
		('site_logo', 'img/logo.png', 0, NULL),
		('support_tickets', NULL, 1, NULL),
		('theme_editor', NULL, 0, NULL),
		('theme', NULL, 0, NULL),
		('tos_lastedited', NULL, 0, '2014-10-29'),
		('featured_package', NULL, 0, NULL),
		('maintenance', NULL, 0, NULL),
		('xenforo_url', NULL, 0, NULL),
		('xenforo_key', NULL, 0, NULL),
		('message_receiverPerma', 'You have received a donator package. {package}. This package is permanent and does not expire.', 0, NULL),
		('message_receiverNonPerma', 'You have received a donator package. {package}. This package is not permanent and expires {expire}.', 0, NULL),
		('message_receiverExpire', 'Your package, {package} has expired.', 0, NULL),
		('message_receiverRevoke', 'Your package, {package} has been revoked. If you believe this is unjustified, please contact an administrator.', 0, NULL),
		('message_receiverCredits', 'You have received {amount} credit(s)', 0, NULL),
		('message_othersCredits', '{name} has donated and received {amount} credit(s)', 0, NULL),
		('message_others', '{name} has received their package, {package} for donating!', 0, NULL),
		('tracking_optout', NULL, 0, NULL),
		('warning_sandbox', NULL, 0, NULL),
		('warning_missingactions', NULL, 0, NULL),
		('last_sitrep', NULL, 0, now()),
		('enable_raffle', NULL, 0, NULL),
		('actions_lastupdated', NULL, 0, now()),
		('enable_globalPackages', NULL, 0, NULL),
		('paymentwall_widgetID', 'p10_1', 0, NULL),
		('payment_gateways', '{\"paypal\":true,\"paymentwall\":false,\"credits\":false,\"stripe\":false}', 0, NULL),
		('paymentwall_reviewKey', NULL, 0, NULL),
		('paymentwall_projectKey', NULL, 0, NULL),
		('paymentwall_secretKey', NULL, 0, NULL),
		('stripe_apiKey', NULL, 0, NULL),
		('stripe_publishableKey', NULL, 0, NULL),
		('credits_only', NULL, 0, NULL),
		('credits_cantransfer', NULL, 1, NULL),
		('store_packageDisplay', NULL, 0, NULL),
		('chargeback_action', NULL, 0, NULL),
		('teamspeak_username', NULL, 0, NULL),
		('teamspeak_password', NULL, 0, NULL),
		('teamspeak_ip', NULL, 0, NULL),
		('teamspeak_queryport', NULL, 0, NULL),
		('teamspeak_port', NULL, 0, NULL),
		('teamspeak_virtualserver', NULL, 0, NULL),
		('show_recent', NULL, 0, NULL),
		('show_top', NULL, 0, NULL),
		('disable_news', NULL, 0, NULL),
		('disable_sorting', NULL, 0, NULL),
		('disable_customjob', NULL, 0, NULL),
		('buy_others', NULL, 1, NULL),
		('imprint_enable', NULL, 0, NULL),
		('imprint_company', NULL, 0, NULL),
		('imprint_street', NULL, 0, NULL),
		('imprint_post', NULL, 0, NULL),
		('imprint_country', NULL, 0, NULL),
		('imprint_traderegister', NULL, 0, NULL),
		('imprint_companyid', NULL, 0, NULL),
		('imprint_ceo', NULL, 0, NULL),
		('imprint_email', NULL, 0, NULL),
		('imprint_phone', NULL, 0, NULL),
		('profile_nononperm', NULL, 0, NULL),
		('profile_noperm', NULL, 0, NULL),
		('profile_nostats', NULL, 0, NULL),
		('christmas_things', NULL, 0, NULL),
		('christmas_advent', NULL, 0, NULL),
		('disable_tos', NULL, 0, NULL),
		('enable_coupons', NULL, 1, NULL),
		('privacy_enable', NULL, 0, NULL)
	");

// TICKETS
$db->execute("CREATE TABLE IF NOT EXISTS tickets (
		id int(11) NOT NULL AUTO_INCREMENT,
		uid varchar(50) NOT NULL,
		descr text NOT NULL,
		text text NOT NULL,
		active int(11) NOT NULL DEFAULT '1',
		seen int(11) NOT NULL DEFAULT '0',
		client_seen int(11) NOT NULL DEFAULT '1',
		timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// TICKET_REPLIES
$db->execute("CREATE TABLE IF NOT EXISTS ticket_replies (
		id int(11) NOT NULL AUTO_INCREMENT,
		ticket_id int(11) DEFAULT NULL,
		uid bigint(20) DEFAULT NULL,
		text text,
		timestamp timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// TRANSACTIONS
$db->execute("CREATE TABLE IF NOT EXISTS transactions (
		id int(11) NOT NULL AUTO_INCREMENT,
		name varchar(50) DEFAULT NULL,
		buyer varchar(50) DEFAULT NULL,
		email varchar(50) DEFAULT NULL,
		uid bigint(20) DEFAULT NULL,
		buyer_uid bigint(20) DEFAULT NULL,
		package int(11) DEFAULT NULL,
		credit_package int(11) DEFAULT NULL,
		raffle_package INT(11) NULL DEFAULT NULL,
		currency varchar(50) DEFAULT NULL,
		price double DEFAULT NULL,
		credits double DEFAULT '0',
		txn_id varchar(50) DEFAULT NULL,
		gateway varchar(50) DEFAULT NULL,
		timestamp timestamp NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// ACTIONS
$db->execute("CREATE TABLE IF NOT EXISTS actions (
		id INT(11) NOT NULL AUTO_INCREMENT,
		transaction INT(11) NOT NULL,
		uid bigint(20) NULL DEFAULT NULL,
		buyer_name VARCHAR(50) NULL DEFAULT NULL,
		actions TEXT NULL,
		forum_claimed INT(11) NULL DEFAULT '0',
		package INT(11) NULL DEFAULT NULL,
		server TEXT NULL,
		runonce INT(11) NOT NULL DEFAULT '1',
		updateable INT(11) NOT NULL DEFAULT '0',
		delivered INT(11) NULL DEFAULT '0',
		active INT(11) NULL DEFAULT '1',
		expiretime DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
		timestamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// RAFFLE
$db->execute("CREATE TABLE IF NOT EXISTS raffles (
		id INT(11) NOT NULL AUTO_INCREMENT,
		title VARCHAR(50) NOT NULL,
		descr TEXT NOT NULL,
		price DOUBLE NOT NULL,
		credits INT(11) NOT NULL,
		currency INT(11) NOT NULL DEFAULT '1',
		package INT(11) NOT NULL,
		img TEXT NOT NULL,
		max_per_person INT(11) NOT NULL DEFAULT '1',
		end_amount INT(11) NOT NULL DEFAULT '10',
		ended INT(11) NOT NULL DEFAULT '0',
		winner BIGINT(20) NULL DEFAULT NULL,
		enabled INT(11) NOT NULL DEFAULT '1',
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

$db->execute("CREATE TABLE IF NOT EXISTS raffle_tickets (
		id INT(11) NOT NULL AUTO_INCREMENT,
		raffle_id INT(11) NULL DEFAULT NULL,
		uid BIGINT(20) NULL DEFAULT NULL,
		timestamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// BLACKLIST
$db->execute("CREATE TABLE IF NOT EXISTS blacklist (
		id INT(11) NOT NULL AUTO_INCREMENT,
		name TEXT NOT NULL,
		steam64 BIGINT(20) NOT NULL,
		steamid VARCHAR(64) NOT NULL,
		timestamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

// PERMISSION_GROUPS
$db->execute("CREATE TABLE IF NOT EXISTS permission_groups (
		id INT(11) NOT NULL AUTO_INCREMENT,
		title VARCHAR(128) NOT NULL,
		json TEXT NOT NULL,
		PRIMARY KEY (id)
		)
		DEFAULT CHARACTER SET utf8   
		COLLATE utf8_general_ci
	");

$db->execute("INSERT INTO permission_groups SET title = ?, json = ?",
    array('root', '["all"]'));

// ADVENT CALENDAR
$db->execute("CREATE TABLE advent_calendar (
	day INT(11) NOT NULL,
	img TEXT NULL,
	package TEXT NULL,
	PRIMARY KEY (day)
	)
	DEFAULT CHARACTER SET utf8   
	COLLATE utf8_general_ci
");

// ADVENT CLAIMS
$db->execute("CREATE TABLE advent_claims (
	id INT(11) NOT NULL AUTO_INCREMENT,
	adv_id INT(11) NULL DEFAULT NULL,
	uid BIGINT(20) NULL DEFAULT NULL,
	timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (id)
	)
	DEFAULT CHARACTER SET utf8   
	COLLATE utf8_general_ci
");

// COUPONS
$db->execute("CREATE TABLE coupons (
		id INT(11) NOT NULL AUTO_INCREMENT,
		coupon TEXT NOT NULL,
		description TEXT NULL,
		packages TEXT NOT NULL,
		percent INT(11) NOT NULL,
		uses INT(11) NOT NULL DEFAULT '0',
		max_uses INT(11) NOT NULL DEFAULT '0',
		expires DATETIME NOT NULL DEFAULT '1000-01-01 00:00:00',
		timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
	)
	DEFAULT CHARACTER SET utf8   
	COLLATE utf8_general_ci
");

// POST LOGS
$db->execute("CREATE TABLE postlogs (
        log TEXT NULL,
        timestamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
    )
    DEFAULT CHARACTER SET utf8
	COLLATE utf8_general_ci
");