<?php

class update
{
    public static function run()
    {
        global $db, $version;

        $lastupdated = getSetting('lastupdated', 'value');
        if ($lastupdated == null) {
            $db->execute("INSERT INTO settings SET name = 'lastupdated'");
        }

        if ($lastupdated != $version) {
            $needs11 = $db->getAll("SELECT featured_package FROM servers");
            $count11 = $db->getOne("SELECT count(*) AS value FROM servers")['value'];
            if ($needs11 == NULL && $count11 != 0) {
                $db->execute("ALTER TABLE servers ADD featured_package INT(11) NOT NULL DEFAULT 0");
                $db->execute("INSERT INTO settings SET name = 'featured_package'");
            }

            $needs12 = $db->getAll("SHOW TABLES LIKE 'actions'");
            if ($needs12 == NULL) {
                $db->execute("CREATE TABLE IF NOT EXISTS actions (
						id INT(11) NOT NULL AUTO_INCREMENT,
						transaction INT(11) NOT NULL,
						uid bigint(20) NULL DEFAULT NULL,
						buyer_name VARCHAR(50) NULL DEFAULT NULL,
						actions TEXT NULL,
						forum_claimed INT(11) NULL DEFAULT '0',
						package INT(11) NULL DEFAULT NULL,
						server TEXT NULL,
						delivered INT(11) NULL DEFAULT '0',
						active INT(11) NULL DEFAULT '1',
						expiretime DATETIME NULL DEFAULT '1000-01-01 00:00:00',
						text TEXT NULL,
						timestamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (id)
						)
					");

                $db->execute("INSERT INTO actions(transaction, uid, delivered, actions, server, active, expiretime) SELECT t.id, t.uid, t.delivered, p.actions, concat('{\"',t.server, '\"}'), t.active, t.expiretime FROM transactions t JOIN packages p ON t.server = p.server AND t.package = p.id");
                $db->execute("ALTER TABLE packages CHANGE server servers TEXT NULL");
                $db->execute("UPDATE packages SET servers=concat('{\"',servers, '\"}')");
                $db->execute("ALTER TABLE transactions DROP COLUMN expiretime, DROP COLUMN delivered, DROP COLUMN active, DROP COLUMN server");

                $db->execute("INSERT INTO settings SET name = 'xenforo_url'");
                $db->execute("INSERT INTO settings SET name = 'xenforo_key'");
            }

            $needs121 = $db->getAll("SELECT * FROM settings WHERE name = 'sale_packages'");
            if ($needs121 == NULL) {
                $db->execute("DELETE FROM settings WHERE name = 'sale_servers';");
                $db->execute("INSERT INTO settings SET name = 'sale_packages';");
            }

            $needs125 = $db->getAll("SHOW TABLES LIKE 'logs'");
            if ($needs125 == NULL) {
                $db->execute("CREATE TABLE IF NOT EXISTS logs (
						id INT(11) NOT NULL AUTO_INCREMENT,
						uid BIGINT(20) NOT NULL DEFAULT '0',
						action TEXT NOT NULL,
						timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (id)
						)
					");
            }

            $needs126 = $db->getAll("SELECT * FROM settings WHERE name = 'maintenance'");
            if ($needs126 == NULL) {
                $db->execute("INSERT INTO settings SET name = 'maintenance';");
            }

            $needs13 = $db->getAll("SELECT custom_price FROM packages");
            $count13 = $db->getOne("SELECT count(*) AS value FROM packages")['value'];
            if ($needs13 == NULL && $count13 != 0) {
                $db->execute("ALTER TABLE packages ADD custom_price INT(11) NOT NULL DEFAULT 0 AFTER days");
            }

            $needs14 = $db->getAll("SELECT * FROM settings WHERE name = 'message_receiverPerma'");
            if ($needs14 == NULL) {
                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('message_receiverPerma', 'You have received a donator package. {package}. This package is permanent and does not expire.'));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('message_receiverNonPerma', 'You have received a donator package. {package}. This package is not permanent and expires {expire}.'));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('message_receiverExpire', 'Your package, {package} has expired.'));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('message_receiverRevoke', 'Your package, {package} has been revoked. If you believe this is unjustified, please contact an administrator.'));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('message_receiverCredits', 'You have received {amount} credit(s)'));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('message_othersCredits', '{name} has donated and received {amount} credit(s)'));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('message_others', '{name} has received their package, {package} for donating!'));

                $db->execute("INSERT INTO settings SET name = ?, value2 = ?",
                    array('tracking_optout', 0));

                $db->execute("INSERT INTO settings SET name = ?, value2 = ?",
                    array('warning_sandbox', 0));

                $db->execute("INSERT INTO settings SET name = ?, value2 = ?",
                    array('warning_missingactions', 0));

                $db->execute("INSERT INTO settings SET name = ?, value2 = ?",
                    array('enable_raffle', 0));

                $db->execute("ALTER TABLE settings CHANGE value3 value3 timestamp NULL DEFAULT NULL");

                $db->execute("INSERT INTO settings SET name = ?, value3 = now()",
                    array('last_sitrep'));

                $db->execute("INSERT INTO settings SET name = ?, value3 = now()",
                    array('actions_lastupdated'));

                $db->execute("ALTER TABLE actions ADD runonce INT(11) NOT NULL DEFAULT 1 AFTER server");

                $db->execute("ALTER TABLE requests ADD debug TEXT AFTER msg");

                $db->execute("ALTER TABLE transactions ADD raffle_package INT(11) NULL DEFAULT NULL AFTER credit_package");

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
					");

                $db->execute("CREATE TABLE IF NOT EXISTS raffle_tickets (
						id INT(11) NOT NULL AUTO_INCREMENT,
						raffle_id INT(11) NULL DEFAULT NULL,
						uid BIGINT(20) NULL DEFAULT NULL,
						timestamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (id)
						)
					");

                $db->execute("ALTER TABLE players CHANGE tos_lastread tos_lastread datetime DEFAULT '1000-01-01 00:00:00'");
            }

            $needs1424 = $db->getAll("SELECT * FROM settings WHERE name = 'enable_globalPackages'");
            if ($needs1424 == NULL) {
                $db->execute("INSERT INTO settings SET name = ?, value2 = 1",
                    array('enable_globalPackages'));
            }

            $needs149 = $db->getAll("SELECT * FROM settings WHERE name = 'paypal_type'");
            if ($needs149 == NULL) {
                $db->execute("ALTER TABLE packages ADD custom_price_min INT(11) NULL DEFAULT 1 AFTER custom_price");
                $db->execute("INSERT INTO settings SET name = ?, value2 = ?",
                    array('paypal_type', 1));
            }

            $needs1493 = $db->getAll("SELECT * FROM settings WHERE name = 'enable_api'");
            if ($needs1493 == NULL) {
                $db->execute("INSERT INTO settings SET name = ?, value2 = ?",
                    array('enable_api', 0));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('api_hash', NULL));

                $db->execute("INSERT INTO settings SET name = ?, value2 = ?",
                    array('monthly_goal', 0));

                $db->execute("INSERT INTO settings SET name = ?, value2 = ?",
                    array('enable_goal', 0));
            }

            $needs15 = $db->getAll("SELECT * FROM settings WHERE name = 'payment_gateways'");
            if ($needs15 == NULL) {
                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('paymentwall_widgetID', 'p10_1'));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('payment_gateways', '{"paypal":true,"paymentwall":false,"credits":false,"stripe":false}'));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('paymentwall_reviewKey', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('paymentwall_projectKey', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('paymentwall_secretKey', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('stripe_apiKey', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('stripe_publishableKey', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('credits_only', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('store_packageDisplay', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('chargeback_action', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('teamspeak_username', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('teamspeak_password', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('teamspeak_ip', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('teamspeak_queryport', ''));

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('teamspeak_port', ''));

                $db->execute("DELETE FROM settings WHERE name = 'enable_credits'");

                $db->execute("ALTER TABLE packages ADD upgradeable VARCHAR(1024) DEFAULT '[]' AFTER non_compatible");

                cache::clear();
            }

            $needs1502 = $db->getAll("SELECT * FROM settings WHERE name = 'teamspeak_virtualserver'");
            if ($needs1502 == NULL) {
                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('teamspeak_virtualserver', ''));

                $db->execute("ALTER TABLE packages ADD hide VARCHAR(1024) DEFAULT '[]' AFTER upgradeable");

                cache::clear();
            }

            $needs1506 = $db->getAll("SELECT value2 FROM settings WHERE name = 'show_recent'");
            if ($needs1506 == NULL) {
                $db->execute("CREATE TABLE IF NOT EXISTS blacklist (
						id INT(11) NOT NULL AUTO_INCREMENT,
						name TEXT NOT NULL,
						steam64 BIGINT(20) NOT NULL,
						steamid VARCHAR(64) NOT NULL,
						timestamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
						PRIMARY KEY (id)
						)
					");

                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('show_recent', ''));

                $db->execute("ALTER TABLE packages ADD subscription INT(11) NOT NULL DEFAULT 0 AFTER hide");

                cache::clear();
            }

            $needs1507 = $db->getAll("SELECT value2 FROM settings WHERE name = 'disable_news'");
            if ($needs1507 == NULL) {
                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('disable_news', ''));

                $db->execute("ALTER TABLE servers ADD image_link TEXT NULL AFTER featured_package");

                cache::clear();
            }

            $needs1508 = $db->getAll("SELECT value2 FROM settings WHERE name = 'show_top'");
            if ($needs1508 == NULL) {
                $db->execute("INSERT INTO settings SET name = ?, value = ?",
                    array('show_top', ''));

                cache::clear();
            }

            $needs1509 = $db->getAll("SELECT updateable FROM actions");
            if ($needs1509 == NULL) {
                $db->execute("ALTER TABLE actions ADD updateable INT(11) NULL DEFAULT 0 AFTER runonce");

                cache::clear();
            }

            $needs151 = $db->getAll("SELECT * FROM permission_groups");
            if ($needs151 == NULL) {
                $db->execute("CREATE TABLE IF NOT EXISTS permission_groups (
						id INT(11) NOT NULL AUTO_INCREMENT,
						title VARCHAR(128) NOT NULL,
						json TEXT NOT NULL,
						PRIMARY KEY (id)
						)
					");

                $db->execute("INSERT INTO permission_groups SET title = ?, json = ?",
                    array('root', '["all"]'));

                $db->execute("ALTER TABLE players ADD perm_group INT(11) NULL DEFAULT '0' AFTER admin");
                $db->execute("UPDATE players SET perm_group = 1 WHERE admin = 1");

                $db->execute("ALTER TABLE packages ADD no_owned INT(11) NULL DEFAULT '0' AFTER hide");
                $db->execute("ALTER TABLE packages ADD order_id INT(11) NULL DEFAULT NULL AFTER id");

                $db->execute("ALTER TABLE transactions ADD gateway varchar(50) DEFAULT NULL AFTER txn_id");

                cache::clear();
            }

            $needs152 = $db->getAll("SELECT * FROM settings WHERE name = 'credits_cantransfer'");
            if ($needs152 == NULL) {
                $db->execute("ALTER TABLE packages ADD bought_disable VARCHAR(1024) DEFAULT '[]' AFTER no_owned");

                $db->execute("INSERT INTO settings SET name = ?, value2 = ?", [
                    'credits_cantransfer', 1,
                ]);

                cache::clear();
            }

            $needs1522 = $db->getAll("SELECT ip FROM players");
            if ($needs1522 == null) {
                $db->execute("ALTER TABLE players ADD ip VARCHAR(45) DEFAULT NULL AFTER tos_lastread");
                $db->execute("UPDATE settings SET value2 = 1 WHERE name = 'paypal_type'");

                cache::clear();
            }

            $needs1532 = $db->getAll("SELECT * FROM settings WHERE name = 'disable_sorting'");
            if ($needs1532 == NULL) {
                $db->execute("ALTER TABLE servers ADD order_id INT(11) NULL DEFAULT NULL AFTER id");

                $db->execute("INSERT INTO settings SET name = ?, value2 = ?", [
                    'disable_sorting', 0,
                ]);

                cache::clear();
            }

            $needs1533 = $db->getAll("SELECT order_id FROM categories");
            if ($needs1533 == NULL) {
                $db->execute("ALTER TABLE categories ADD order_id INT(11) NULL DEFAULT NULL AFTER id");

                cache::clear();
            }

            $needs154 = $db->getAll("SELECT * FROM prepurchase");
            if ($needs154 == NULL) {
                $db->execute("CREATE TABLE IF NOT EXISTS prepurchase (
					  id INT(11) NOT NULL AUTO_INCREMENT,
					  type VARCHAR(50) NOT NULL,
					  uid BIGINT(20) NOT NULL,
					  json TEXT NOT NULL,
					  delivered TINYINT(4) NOT NULL DEFAULT '0',
					  extra TEXT NULL,
					  timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  PRIMARY KEY (id)
					)");

                $db->execute("INSERT INTO settings SET name = ?, value2 = ?", [
                    'disable_customjob', 0,
                ]);

                $db->execute("INSERT INTO settings SET name = ?, value = ?", [
                    'site_banner', 'img/banner.png',
                ]);

                $db->execute("INSERT INTO settings SET name = ?, value = ?", [
                    'site_logo', 'img/logo.png',
                ]);

                $db->execute("ALTER TABLE packages ADD COLUMN alternative_paypal VARCHAR(50) NULL DEFAULT NULL AFTER category");

                cache::clear();
            }

            $needs16 = $db->getAll("SELECT * FROM settings WHERE name = 'imprint_enable'");
            if ($needs16 == NULL) {
                $db->execute("INSERT INTO settings SET name = ?, value = ?", [
                    'theme', '',
                ]);

                $db->execute("INSERT INTO settings SET name = ?, value2 = ?", [
                    'buy_others', 1,
                ]);

                /**
                 * Imprint
                 */
                $db->execute("INSERT INTO settings SET name = ?, value2 = ?", [
                    'imprint_enable', 0,
                ]);

                $db->execute("INSERT INTO settings SET name = ?", [
                    'imprint_company',
                ]);

                $db->execute("INSERT INTO settings SET name = ?", [
                    'imprint_street',
                ]);

                $db->execute("INSERT INTO settings SET name = ?", [
                    'imprint_post',
                ]);

                $db->execute("INSERT INTO settings SET name = ?", [
                    'imprint_country',
                ]);

                $db->execute("INSERT INTO settings SET name = ?", [
                    'imprint_traderegister',
                ]);

                $db->execute("INSERT INTO settings SET name = ?", [
                    'imprint_companyid',
                ]);

                $db->execute("INSERT INTO settings SET name = ?", [
                    'imprint_ceo',
                ]);

                $db->execute("INSERT INTO settings SET name = ?", [
                    'imprint_email',
                ]);

                $db->execute("INSERT INTO settings SET name = ?", [
                    'imprint_phone',
                ]);

                cache::clear();
            }

            $needs161 = $db->getAll("SELECT game FROM servers");
            if ($needs161 == NULL) {
                $db->execute("ALTER TABLE settings CHANGE COLUMN value value TEXT NULL DEFAULT NULL AFTER name");
                $db->execute("ALTER TABLE servers ADD COLUMN game VARCHAR(50) NULL AFTER order_id");
                $db->execute("ALTER TABLE servers ADD COLUMN ip VARCHAR(50) NULL DEFAULT NULL AFTER game");
                $db->execute("ALTER TABLE servers ADD COLUMN port VARCHAR(50) NULL DEFAULT NULL AFTER ip");
                $db->execute("ALTER TABLE servers ADD COLUMN rcon TEXT NULL DEFAULT NULL AFTER port");

                $db->execute("INSERT INTO settings SET name = ?", [
                    'profile_nostats',
                ]);

                $db->execute("INSERT INTO settings SET name = ?", [
                    'profile_nononperm',
                ]);

                $db->execute("INSERT INTO settings SET name = ?", [
                    'profile_noperm',
                ]);

                cache::clear();
            }


            $needs1615 = $db->getAll("SELECT * FROM settings WHERE name = 'christmas_things'");
            if ($needs1615 == NULL) {
                $db->execute("INSERT INTO settings SET name = ?, value2 = 0", [
                    'christmas_things',
                ]);

                $db->execute("INSERT INTO settings SET name = ?, value2 = 0", [
                    'christmas_advent',
                ]);

                $db->execute("CREATE TABLE IF NOT EXISTS advent_calendar (
                    day INT(11) NOT NULL,
                    img TEXT NULL,
                    package TEXT NULL,
                    PRIMARY KEY (day)
                )");

                $db->execute("CREATE TABLE IF NOT EXISTS advent_claims (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    adv_id INT(11) NULL DEFAULT NULL,
                    uid BIGINT(20) NULL DEFAULT NULL,
                    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id)
                )");

            }

            $needs1616 = $db->getAll("SELECT once FROM packages");
            if ($needs1616 == NULL) {
                $db->execute("ALTER TABLE packages ADD COLUMN once INT(11) NULL DEFAULT 0 AFTER subscription");
            }

            $needs162 = $db->getAll("SELECT value FROM settings WHERE name = 'enable_coupons'");
            if ($needs162 == NULL) {
                $db->execute("INSERT INTO settings SET name = ?, value2 = 1", [
                    'enable_coupons',
                ]);

                $db->execute("INSERT INTO settings SET name = ?, value2 = 0", [
                    'disable_tos',
                ]);

                $db->execute("CREATE TABLE coupons (
                        id INT(11) NOT NULL AUTO_INCREMENT,
                        coupon TEXT NOT NULL,
                        description TEXT NULL,
                        packages TEXT NOT NULL,
                        percent INT(11) NOT NULL,
                        uses INT(11) NOT NULL DEFAULT '0',
                        max_uses INT(11) NOT NULL DEFAULT '0',
                        expires TIMESTAMP NULL DEFAULT NULL,
                        timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (id)
                    )
                    DEFAULT CHARACTER SET utf8
                    COLLATE utf8_general_ci
                ");
            }

            $needs163 = $db->getAll("SELECT * FROM postlogs");
            if ($needs163 == NULL) {
                $db->execute("CREATE TABLE postlogs (
                        log TEXT NULL,
                        timestamp TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
                    )
                    DEFAULT CHARACTER SET utf8
                    COLLATE utf8_general_ci
                ");
            }

            $needs16312 = $db->getAll("SELECT * FROM actions WHERE expiretime = '0000-00-00'");
            if ($needs16312 != NULL) {
                $db->execute("
                    UPDATE actions SET expiretime = '1000-01-01' WHERE expiretime = '0000-00-00'
                ");

                $db->execute("
                    ALTER TABLE actions MODIFY COLUMN expiretime datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
                ");

                $db->execute("
                    UPDATE coupons SET expires = '1000-01-01' WHERE expires = '0000-00-00'
                ");

                $db->execute("
                    ALTER TABLE coupons MODIFY COLUMN expires datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
                ");
            }

            $needs16314 = $db->getAll("SELECT * FROM players WHERE tos_lastread = '0000-00-00 00:00:00'");
            if ($needs16314 != NULL) {
                $db->execute("
                    UPDATE players SET tos_lastread = '1000-01-01' WHERE tos_lastread = '0000-00-00 00:00:00'
                ");

                $db->execute("
                    ALTER TABLE players MODIFY COLUMN tos_lastread datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
                ");
            }

            $needs16315 = $db->getAll("SELECT * FROM players LIMIT 1");
            if (!isset($needs16315[0]['created_at'])) {
                $db->execute("
                    ALTER TABLE players ADD COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER ip;
                ");

                $db->execute("
                    ALTER TABLE players ADD COLUMN email TEXT NULL DEFAULT NULL AFTER name;
                ");

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
            }

            setSetting($version, 'lastupdated', 'value');
        }

        $needs16320 = $db->getAll("SELECT * FROM settings WHERE name = 'halloween_things'");
        if (count($needs16320) == 0) {
            $db->execute("INSERT INTO settings SET name = 'halloween_things'");
        }

        $needs16321 = $db->getAll("SELECT * FROM settings WHERE name = 'disable_theme_selector'");
        if (count($needs16321) == 0) {
            $db->execute("INSERT INTO settings SET name = 'disable_theme_selector'");
            $db->execute("INSERT INTO settings SET name = 'disable_language_selector'");
        }

        $needs16323 = $db->getAll("SELECT * FROM pages WHERE page = 'privacy'");
        if (count($needs16323) == 0) {
            $db->execute("INSERT INTO pages SET page = 'privacy', content = '<p><strong>THIS IS AN EXAMPLE PRIVACY POLICY. REPLACE ANYTHING BETWEEN % AND % BEFORE USE. ALTERNATIVELY, USE YOUR OWN.</strong><br><br><br></p><p>This privacy policy governs the manner in which %COMMUNITY% collects, uses, maintains and discloses information collected from users (each, a \"User\") of the %HTTP://COMMUNITY.COM% website (\"Site\"). This privacy policy applies to the Site and all products and services offered by %COMMUNITY%.</p><br><p><strong>Personal identification information</strong><br>We may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users visit our site, register on the site, place an order, and in connection with other activities, services, features or resources we make available on our Site. Users may visit our Site anonymously. We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personally identification information, except that it may prevent them from engaging in certain Site related activities.</p><br><p>This Site uses the Steam Web APIs to retrieve data about users only when those users login using the Steam OpenID provider. The data we store from the Steam Web APIs include 64-bit Steam IDs, Steam Community names, and URLs to Steam Community avatar images.</p><br><p><strong>Web browser cookies</strong><br>Our Site may use \"cookies\" to enhance User experience. Users web browser places cookies on their hard drive for record-keeping purposes and sometimes to track information about them. User may choose to set their web browser to refuse cookies, or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly.</p><p><strong><br></strong></p><p><strong>How we use collected information</strong><br>%COMMUNITY% may collect and use Users personal information for the following purposes:</p><ol><li>To process payments: We may use the information Users provide about themselves when placing an order only to provide service to that order. We do not share this information with outside parties except to the extent necessary to provide the service.</li></ol><br><p><strong>Sharing your personal information</strong><br>We do not sell, trade, or rent Users personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners, trusted affiliates and advertisers for the purposes outlined above.</p><p><strong><br></strong></p><p><strong>Your acceptance of these terms</strong><br>By using this Site you signify your acceptance of this policy. If you do not agree to this policy, please do not use our Site. Your continued use of the Site following the posting of changes to this policy will be deemed your acceptance of those changes.</p><p><strong><br></strong></p><p><strong>Contacting us</strong><br>If you have any questions about this Privacy Policy, the practices of this site, or your dealings with this site, please contact us at: %PLACEHOLDER@EMAIL.COM%<br></p>'");

            $db->execute("INSERT INTO settings SET name = ?, value2 = ?", [
                'privacy_enable', 0,
            ]);
        }

        setSetting($version, 'lastupdated', 'value');
    }
}