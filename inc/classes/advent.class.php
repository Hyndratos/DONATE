<?php 

	class advent {
		public static function populate(){
			global $db;

			$res = $db->getOne("SELECT count(*) AS count FROM advent_calendar");

			if($res == 0){
				// Table is empty
				
				$db->execute("INSERT INTO advent_calendar (day, img, package) VALUES
					(1, 'http://orig00.deviantart.net/1b08/f/2010/196/f/7/christmas_in_garry__s_mod_by_xxzealxx82.jpg', NULL),
					(2, 'http://i388.photobucket.com/albums/oo324/Dark_Magician_MF/TF%202/Garrys%20Mod/Christmas2010.jpg', NULL),
					(3, 'http://s2.dmcdn.net/IJofj/1280x720-eF-.jpg', NULL),
					(4, 'http://media.moddb.com/images/downloads/1/40/39016/dm_christmas_in_the_suburbs0004.jpg', NULL),
					(5, 'http://media.moddb.com/images/downloads/1/39/38675/dm_christmas_bungalow0001.jpg', NULL),
					(6, 'http://s1.dmcdn.net/IG6Kr/1280x720-fpc.jpg', NULL),
					(7, 'http://bbsimg.ngfiles.com/15/20521000/ngbbs4b34011fa9154.jpg', NULL),
					(8, 'http://img09.deviantart.net/8fcf/i/2013/358/9/c/_garry_s_mod__and_thus_i_shall_be_christmas_tree__by_mechaelite-d6z98so.jpg', NULL),
					(9, 'http://local-static0.forum-files.fobby.net/forum_attachments/0020/0210/gm_snowstruct20000.jpg', NULL),
					(10, 'http://orig08.deviantart.net/394e/f/2012/338/d/a/gmod__christmas_party_by_jayemeraldover9000x-d5n0xsd.jpg', NULL),
					(11, 'http://content.ytmnd.com/content/b/8/6/b86df0da6b862be2569b64eacf6fcf98.jpg', NULL),
					(12, 'http://i.cubeupload.com/Air7I2.jpg', NULL),
					(13, 'http://bbsimg.ngfiles.com/15/20514000/ngbbs4b32351345bc7.jpg', NULL),
					(14, 'https://i.ytimg.com/vi/9lpcHaqi1lw/maxresdefault.jpg', NULL),
					(15, 'http://i.ytimg.com/vi/WAxbjqtkYvE/maxresdefault.jpg', NULL),
					(16, 'http://media.tumblr.com/tumblr_lwpcy26NXg1qliuhb.png', NULL),
					(17, 'http://fc08.deviantart.net/fs71/i/2012/358/2/9/merry_christmas_from_gmod_by_segajosh3-d5p2tmv.jpg', NULL),
					(18, 'http://orig10.deviantart.net/bd51/f/2009/352/7/d/rp_christmastown___gmod_by_theofficalmiga.jpg', NULL),
					(19, 'http://img05.deviantart.net/2360/i/2010/336/8/c/gmod_christmas_by_dinmamma3000-d341zld.jpg', NULL),
					(20, 'http://cloud-2.steamusercontent.com/ugc/542945375824654298/CBD312F9F24BD6E0F8702333DE7D0D4014EE4156/637x358.resizedimage', NULL),
					(21, 'http://files.gamebanana.com/img/ss/maps/4eda543066eb8.jpg', NULL),
					(22, 'https://files.garrysmods.org/14499/1/1024x768.jpg', NULL),
					(23, 'http://fc08.deviantart.net/fs70/f/2013/262/6/d/invasion_of_christmas_trees_by_madman5333-d6my5bt.jpg', NULL),
					(24, 'http://img13.deviantart.net/70cd/i/2010/120/b/e/christmas_cheers_by_garrys_mod_dude.jpg', NULL)
				");
			}
		}

		public static function update($image, $pkg){
			global $db;

			for ($i=1; $i <= 24; $i++) { 
				if(!isset($pkg[$i])){
					$pkg[$i] = [];
				}
				
				$db->execute("UPDATE advent_calendar SET img = ?, package = ? WHERE day = ?", [
					$image[$i], json_encode($pkg[$i]), $i
				]);
			}
		}

		public static function getForm(){
			global $db;

			$ret = '';
			$res = $db->getAll("SELECT * FROM advent_calendar");

			$template = '
				<div class="col-xs-4">
				    <div class="form-group darker-box">
	                    <h6>%DAY%</h6>

	                    <select class="selectpicker bs-select-hidden" multiple="" data-live-search="true" name="pkg[%PLAINDAY%][]" title="Select packages\'s" data-style="btn-prom" data-width="100%">
	                        %OPTIONS%
	                    </select>

	                    <input type="text" name="image[%PLAINDAY%]" class="form-control" placeholder="Image background" style="margin-top: 5px;" value="%IMAGE%">
	                </div>
	            </div>
			';

			if($res){
				$packages = $db->getAll("SELECT id, title FROM packages");

				foreach($res as $row){
					$image = $row['img'];
					$day = lang('day') . ' ' . $row['day'];
					$plainday = $row['day'];
					$package = $row['package'];

					if($package == '' or $package == null or $package == 'null'){
						$package = '[]';
					}

					$package = json_decode($package, true);

					$options = '';

					foreach($packages as $pkg){
						$selected = '';

						$id = $pkg['id'];
						$title = $pkg['title'];

						if(in_array($id, $package)){
							$selected = 'selected';
						}

						$options .= '<option value="'.$id.'" '.$selected.'>'.$title.'</option>';
					}

					$temp = $template;

					$temp = str_replace([
						'%DAY%', 
						'%OPTIONS%', 
						'%IMAGE%', 
						'%PLAINDAY%'
					], [
						$day, 
						$options, 
						$image, 
						$plainday
					], $temp);

					$ret .= $temp;
				}
			}

			return $ret;
		}

		public static function getPage(){
			global $db;

			$ret = '';
			$res = $db->getAll("SELECT * FROM advent_calendar");

			$template = '
				<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
		            %LINKSTART%
		                <div class="advent-box %CLAIMED% %NOTYET%">
		                    <img src="%IMAGE%">
		                    <span>%DAY%</span>
		                </div>
		            %LINKEND%
		        </div>
			';

			if($res){
				$claimedArray = advent::claimedAll();

				foreach($res as $row){
					$notyet = 'notyet';
					$claimed = '';

					$image = $row['img'];
					$day = lang('day') . ' ' . $row['day'];
					$plainday = $row['day'];

					$linkstart = '';
					$linkend = '';

					if (advent::canClaim($plainday)) {
						$notyet = '';
						$linkstart = '<a href="store.php?page=advent&claim='.$plainday.'">';
						$linkend = '</a>';
					}

					if(in_array($plainday, $claimedArray)){
						$claimed = 'claimed';
						$linkstart = '';
						$linkend = '';
					}

					$temp = $template;

					$temp = str_replace([
						'%DAY%', 
						'%IMAGE%', 
						'%PLAINDAY%',
						'%CLAIMED%',
						'%NOTYET%',
						'%LINKSTART%',
						'%LINKEND%'
					], [
						$day, 
						$image, 
						$plainday,
						$claimed,
						$notyet,
						$linkstart,
						$linkend
					], $temp);

					$ret .= $temp;
				}
			}

			return $ret;
		}

		public static function canClaim($day){
			$year = date('Y');

			if(new DateTime() >= new DateTime("$year-12-$day 00:00:00")){
				return true;
			} else {
				return false;
			}
		}

		public static function claimedAll(){
			global $db, $UID;

			$ids = [];
			$res = $db->getAll("SELECT adv_id FROM advent_claims WHERE uid = ?", $UID);

			if($res){
				foreach($res as $row){
					$ids[] = $row['adv_id'];
				}
			}

			return $ids;
		}

		public static function claimed($day){
			global $db, $UID;

			$res = $db->getAll("SELECT * FROM advent_claims WHERE adv_id = ? AND uid = ?", [
				$day, $UID
			]);

			if($res){
				return true;
			} else {
				return false;
			}
		}

		public static function claim($day){
			global $db, $UID;

			if(isset($_SESSION['lastPurchase'])){
			    $lastPurchase = $_SESSION['lastPurchase'];

			    if(time() <= $lastPurchase + 10){
			        exit;
			    }
			}

			$_SESSION['lastPurchase'] = time();

			$id = 0;

			// Give the user the pkg
			
			$pkg = $db->getOne("SELECT package FROM advent_calendar WHERE day = ?", $day);

			if($pkg != '' && $pkg != NULL && $pkg != 'null'){
				$packages = json_decode($pkg, true);

				$id = $packages[rand(0, count($packages)-1)];

				$p_array = array(
		            "id" => $id,
		            "trans_id" => 0,
		            "uid" => $UID,
		            "type" => 1
		        );
		        addAction($p_array);

		        $name = 'Assigned from advent calendar';
		        $email = 'Assigned from advent calendar';
		        $txn_id = 'Assigned from advent calendar';
		        $price = 0;

		        $db->execute("INSERT INTO transactions SET name = ?, email = ?, uid = ?, package = ?, price = ?, txn_id = ?", [
			        $name, $email, $UID, $id, $price, $txn_id,
			    ]);

			    $db->execute("INSERT INTO advent_claims SET adv_id = ?, uid = ?", [$day, $UID]);
	  		}

	  		return $id;
		}
	}

?>