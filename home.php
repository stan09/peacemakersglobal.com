<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("config/connect.php");
include("includes/fetch_users_info.php");
include ("includes/time_function.php");
include ("includes/num_k_m_count.php");
if(!isset($_SESSION['Username'])){
    header("location: index");
}
if (is_dir("imgs/")) {
        $check_path = "";
    }elseif (is_dir("../imgs/")) {
        $check_path = "../";
    }elseif (is_dir("../../imgs/")) {
        $check_path = "../../";
    }
?>
<html dir="<?php echo lang('html_dir'); ?>">
<head>
    <title>Home | peacemaker's</title>
    <meta charset="UTF-8">
    <meta name="description" content="peacemaker's is a social network platform helps you meet new friends and stay connected with your family and with who you are interested anytime anywhere.">
    <meta name="keywords" content="social network,social media,peacemaker's,meet,free platform">
    <meta name="author" content="Munaf Aqeel Mahdi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "includes/head_imports_main.php"; ?>
</head>
<body onLoad="fetchPosts_DB('home');">
<!--=============================[ NavBar ]========================================-->
<?php include "includes/navbar_main.php"; ?>
<!--=============================[ Div_Container ]========================================-->
<div class="main_container" align="center">
<!--====================================[ Center col's ]============================================-->
    <div style="display: inline-flex" align="center">
<!--====================================[ Center col1 ]============================================-->
    <div class="centerCol" align="left">
        <div id="centerCol_Content">
<div class="homeLinks" style="text-align:<?php echo lang('homeLinks'); ?>">
<div align="center">
  <div align="center" class="userinfo_homeLinks">
  <a href="u/<?php echo $_SESSION['Username']; ?>">
    <img src="<?php echo 'imgs/user_imgs/'.$_SESSION['Userphoto']; ?>">
  </a>
  </div>
  <h3 style="margin:5px;font-size:18px;"><?php echo "<a href='u/".$_SESSION['Username']."'>".$_SESSION['Fullname']."</a>"; if ($_SESSION['verify'] == "1"){echo $verifyUser;} ?></h3>
<p align="center">@<?php echo $_SESSION['Username'];?></p>
<?php
 echo "<span style='cursor:pointer;width:95%;display:inline-flex;margin:5px;'><a href='settings?tc=edit_profile' class=\"silver_flat_btn\" style='width:100%;'><span class=\"fa fa-cog\"></span> ".lang('edit_profile')."</a></span>";
?>
</div>
<a href="./u/<?php echo $_SESSION['Username']; ?>&ut=photos"><p class="<?php echo lang('HLP_b'); ?>"><img src="imgs/main_icons/1f5fb.png" /> <?php echo lang('my_photos'); ?></p></a>
<a href="./settings"><p class="<?php echo lang('HLP_b'); ?>"><img src="imgs/main_icons/2699.png" /> <?php echo lang('settings'); ?></p></a>
<a href="./settings?tc=language"><p class="<?php echo lang('HLP_b'); ?>"><img src="imgs/main_icons/1f998c4.png" /> <?php echo lang('language'); ?></p></a>

<p class="homeLinks_title"><?php echo lang('my_notepad'); ?></p>
<a href="./mynotepad/new"><p class="<?php echo lang('HLP_b'); ?>"><img src="imgs/main_icons/270f.png" /> <?php echo lang('new_note'); ?></p></a>
<?php
$msid = $_SESSION['id'];
$get_notes_sql="SELECT id,note_title FROM mynotepad WHERE author_id=:msid ORDER BY note_time DESC LIMIT 3";
$get_notes = $conn->prepare($get_notes_sql);
$get_notes->bindParam(':msid',$msid,PDO::PARAM_INT);
$get_notes->execute();
$notesCount = $get_notes->rowCount();
while($note_i = $get_notes->fetch(PDO::FETCH_ASSOC)){
$get_note_id = $note_i['id'];
$get_note_title = $note_i['note_title'];
?>
<a href="./mynotepad/"><p class="<?php echo lang('HLP_b'); ?>"><img src="imgs/main_icons/1f5d2.png" /> <?php if(strlen($get_note_title) > 20 ){$noteitem = substr($get_note_title, 0,20)."...";}else{$noteitem = $get_note_title;} echo $noteitem; ?></p></a>
<?php
}
?>
<a href="./mynotepad/"><p class="<?php echo lang('HLP_b'); ?>"><img src="imgs/main_icons/1f4d1.png" /> <?php echo lang('see_all_notes')."<span>".thousandsCurrencyFormat($notesCount)."</span>"; ?></p></a>

<p class="homeLinks_title"><?php echo lang('recently_starts_from'); ?></p>
<?php
$mYiD = $_SESSION['id'];
$getS_sql = "SELECT * FROM r_star WHERE p_id =:mYiD ORDER BY id DESC LIMIT 5";
$getS = $conn->prepare($getS_sql);
$getS->bindParam(':mYiD',$mYiD,PDO::PARAM_INT);
$getS->execute();
while ($getS_row = $getS->fetch(PDO::FETCH_ASSOC)) {
    $getuserid = $getS_row['u_id'];
    $getuser_sql = "SELECT Username,Userphoto,Fullname FROM signup WHERE id=:getuserid";
    $getuser = $conn->prepare($getuser_sql);
    $getuser->bindParam(':getuserid',$getuserid,PDO::PARAM_INT);
    $getuser->execute();
    while ($getuser_row = $getuser->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <a href="u/<?php echo $getuser_row['Username']; ?>"><p class="<?php echo lang('HLP_b'); ?>"><img src="imgs/user_imgs/<?php echo $getuser_row['Userphoto']; ?>" style="border-radius: 100%;" /> <?php echo $getuser_row['Fullname']; ?></p></a>
    <?php
    }
}
?>
<a href="./u/<?php echo $_SESSION['Username']; ?>&ut=stars"><p class="<?php echo lang('HLP_b'); ?>"><img src="imgs/main_icons/1f4ab.png" /> <?php echo lang('see_all_notes'); ?></p></a>

<p class="homeLinks_title"><?php echo lang('more'); ?></p>
<a href="./posts/saved"><p class="<?php echo lang('HLP_b'); ?>"><img src="imgs/main_icons/1f516.png" /> <?php echo lang('saved_posts'); ?></p></a>
<a href="page/supportbox"><p class="<?php echo lang('HLP_b'); ?>"><img src="imgs/main_icons/1f4e5.png" /> <?php echo lang('supportBox'); ?></p></a>
<a href="page/report"><p class="<?php echo lang('HLP_b'); ?>"><img src="imgs/main_icons/1f4e4.png" /> <?php echo lang('Report_A_Problem'); ?></p></a>
    </div>
        </div>
        <table width="245">
<tr>
<th><img src="Karibuni.jpg" width="245" /></th>
<tr>
<td><font color="#0000FF">Be unique with Stan Culture Product's, whatsapp number +255756702385. Your welcome</font></td>
</tr>
</tr></table>
<br>

      <table width="245">
<tr>
<th><img src="2018.jpg" width="245" /></th>
<tr>
<td></td>
</tr>
</tr></table>
<br>
      <table width="245">
<tr>
<th><img src="stanposter.jpg" width="245" /></th>
<tr>
<td><font color="#0000FF"><b>Your talent is your weapon</b></font></td>
</tr>
</tr></table>
<br>
      <table width="245">
<tr>
<th><img src="we are peacemakers.jpg" width="245" /></th>
<tr>
<td></td>
</tr>
</tr></table>
    </div>
<!--======================[ end Center col1 ]=============================-->
<!--========================[ Center col2 ]===============================-->
        <div align="left">
            <div class="centerCol_2">
            <?php 
            $uid = $_SESSION['id'];
            $sqlQ = "SELECT aSetup FROM signup WHERE id=:uid";
            $sqlQ_check = $conn->prepare($sqlQ);
            $sqlQ_check->bindParam(':uid',$uid,PDO::PARAM_INT);
            $sqlQ_check->execute();
            while ($aSetupDB = $sqlQ_check->fetch(PDO::FETCH_ASSOC)) {
                $aSetupFromDb = $aSetupDB['aSetup'];
            }
            if ($aSetupFromDb != 100) {
            ?>
            <div id="AccountSetup">
            <div class="post">
                <p style="padding: 8px; color: #03A9F4; font-size: 16px; border-bottom: 1px solid #ececec; margin: 10 15;text-align:<?php echo lang('textAlign') ?>;"><?php echo lang('accountSetup') ?></p>
                <!--==========[ Account Setup ]=========-->
                <div class="aSetup" align="center">
                    <div class="aSetup_item">
                        <?php 
                        $aSetupVal = array();
                        if(empty($_SESSION['Userphoto']) or $_SESSION['Userphoto'] == "user-male.png" or $_SESSION['Userphoto'] == "user-female.png"){
                            $cUphotoClass = "aSetup_item_empty";
                            $cUphotoColor = "color: #c3c3c3;";
                        }else{
                            $cUphotoClass = "aSetup_item_done";
                            $cUphotoColor = "color: #4bd37b;";
                            if (!in_array('Userphoto', $aSetupVal)) {
                                array_push($aSetupVal,'Userphoto');
                            }
                        } ?>
                        <div class="<?php echo $cUphotoClass; ?>"></div>
                        <p style="<?php echo $cUphotoColor; ?>"><?php echo lang('as_userPhoto') ?></p>
                        <?php if(!in_array('Userphoto', $aSetupVal)){ ?><a href="u/<?php echo $_SESSION['Username'] ?>"><?php echo lang('complete') ?></a><?php } ?>
                    </div>
                    <div class="aSetup_item">
                        <?php if(empty($_SESSION['uCoverPhoto'])){
                            $cCphotoClass = "aSetup_item_empty";
                            $cCphotoColor = "color: #c3c3c3;";
                        }else{
                            $cCphotoClass = "aSetup_item_done";
                            $cCphotoColor = "color: #4bd37b;";
                            if (!in_array('uCoverPhoto', $aSetupVal)) {
                                array_push($aSetupVal,'uCoverPhoto');
                            }
                        } ?>
                        <div class="<?php echo $cCphotoClass; ?>"></div>
                        <p style="<?php echo $cCphotoColor; ?>"><?php echo lang('as_coverPhoto') ?></p>
                        <?php if(!in_array('uCoverPhoto', $aSetupVal)){ ?><a href="u/<?php echo $_SESSION['Username'] ?>"><?php echo lang('complete') ?></a><?php } ?>
                    </div>
                    <div class="aSetup_item">
                        <?php if(empty($_SESSION['school']) or empty($_SESSION['work0']) or empty($_SESSION['work']) or empty($_SESSION['country']) or empty($_SESSION['website']) or empty($_SESSION['bio']) or empty($_SESSION['birthday'])){
                            $cInfoClass = "aSetup_item_empty";
                            $cInfoColor = "color: #c3c3c3;";
                        }else{
                            $cInfoClass = "aSetup_item_done";
                            $cInfoColor = "color: #4bd37b;";
                            if (!in_array('CompleteInfo', $aSetupVal)) {
                                array_push($aSetupVal,'CompleteInfo');
                            }
                        } ?>
                        <div class="<?php echo $cInfoClass; ?>"></div>
                        <p style="<?php echo $cInfoColor; ?>"><?php echo lang('as_profileInfo') ?></p>
                        <?php if(!in_array('CompleteInfo', $aSetupVal)){ ?><a href="settings?tc=edit_profile"><?php echo lang('complete') ?></a><?php } ?>
                    </div>
                    <div class="aSetup_item">
                        <?php
                        $uid = $_SESSION['id'];
                        $sqlQ = "SELECT * FROM follow WHERE uf_one = :uid";
                        $sqlQ_check = $conn->prepare($sqlQ);
                        $sqlQ_check->bindParam(':uid',$uid,PDO::PARAM_INT);
                        $sqlQ_check->execute();
                        $sqlQ_checkCount = $sqlQ_check->rowCount();
                        if ($sqlQ_checkCount > 0) {
                            $cFollowClass = "aSetup_item_done";
                            $cFollowColor = "color: #4bd37b;";
                            if (!in_array('followPeople', $aSetupVal)) {
                                array_push($aSetupVal,'followPeople');
                            }
                        }else{
                            $cFollowClass = "aSetup_item_empty";
                            $cFollowColor = "color: #c3c3c3;";
                        }
                        ?>
                        <div class="<?php echo $cFollowClass; ?>"></div>
                        <p style="<?php echo $cFollowColor; ?>"><?php echo lang('as_followPeople') ?></p>
                        <?php if(!in_array('followPeople', $aSetupVal)){ ?><a href="search"><?php echo lang('complete') ?></a><?php } ?>
                    </div>
                </div>
                <div class="aSetup_progrDiv" style="text-align: <?php echo lang('textAlign'); ?>">
                <?php
                $aSetupVal = count($aSetupVal);
                switch ($aSetupVal) {
                    case '1':
                        $aSetupProg = "25";
                    break;
                    case '2':
                        $aSetupProg = "50";
                    break;
                    case '3':
                        $aSetupProg = "75";
                    break;
                    case '4':
                        $aSetupProg = "100";
                    break;
                    default:
                        $aSetupProg = "0";
                    break;
                }
                ?>
                    <p style="width: <?php echo $aSetupProg; ?>%;"><?php if($aSetupProg > 0){echo $aSetupProg.'%';} ?></p>
                </div>
                
                </div>
            </div>
            <?php 
            if ($aSetupProg == 100 ) {
                $uid = $_SESSION['id'];
                $sqlQ = "UPDATE signup SET aSetup = :aSetupProg WHERE id = :uid";
                $sqlQ_check = $conn->prepare($sqlQ);
                $sqlQ_check->bindParam(':aSetupProg',$aSetupProg,PDO::PARAM_INT);
                $sqlQ_check->bindParam(':uid',$uid,PDO::PARAM_INT);
                $sqlQ_check->execute();
                echo "<script>$('#AccountSetup').html('');</script>";
            }
            }
            ?>
            <!--==========[ End Account Setup ]=========-->
                <div class="write_post">
                <?php echo $err_success_Msg; ?>
                    <?php include("includes/w_post_form.php"); ?>
                </div>
                   <div id="FetchingPostsDiv">
                </div>
                <div class="post loading-info" id="LoadingPostsDiv" style="padding: 8px;padding-bottom: 100px;">
                    <div class="animated-background">
                        <div class="background-masker header-top"></div>
                        <div class="background-masker header-left"></div>
                        <div class="background-masker header-right"></div>
                        <div class="background-masker header-bottom"></div>
                        <div class="background-masker subheader-left"></div>
                        <div class="background-masker subheader-right"></div>
                        <div class="background-masker subheader-bottom"></div>
                        <div class="background-masker content-top"></div>
                        <div class="background-masker content-first-end"></div>
                        <div class="background-masker content-second-line"></div>
                        <div class="background-masker content-second-end"></div>
                        <div class="background-masker content-third-line"></div>
                        <div class="background-masker content-third-end"></div>
                    </div>
                </div>
                <div class="post  loading-info" id="NoMorePostsDiv" style="display: none;">
                  <p style="color: #b1b1b1;text-align: center;padding: 15px;margin: 0px;font-size: 18px;"><?php echo lang('noMoreStories'); ?></p>
                </div>
                <div class="post  loading-info" id="LoadMorePostsBtn" style="display: none;">
                  <button class="blue_flat_btn" style="width: 100%" onClick="fetchPosts_DB('home')"><?php echo lang('load_more'); ?></button>
                </div>
                <input type="hidden" id="GetLimitOfPosts" value="0">
        </div>
        </div>
<!--====================================[ end Center col2 ]============================================-->
<!--====================================[ Center col3 ]============================================-->
        <div align="left">
         <div id="centerCol3" style="width: 310px">
          <div class="centerCol_3" style="text-align: <?php echo lang('textAlign'); ?>;">
          <!--==================[Trending]===================-->
          <div id="trendingWorldWide">
              <p class="trendingTitle_CenterCol_3"><span class="fa fa-globe"></span> <?php echo lang('trending_worldWide'); ?></p>
          <div class="trendingTitle_CenterCol_3" style="background: #e9ebee;"><a href="#" id="trPagesTab" style="background: #fff;"><?php echo lang('pages'); ?></a> <a href="#" id="trPostsTab"><?php echo lang('posts'); ?></a></div>
          <div id="trendingPostsPagesLoading" style="display: none;background: url(imgs/loading_video.gif) center center no-repeat;width: 100%;height: 100px">
          </div>
          <div id="trendingPostsPages">
            <script>
            function trendingPostsPages() {
                $.ajax({
                    url:'includes/fetchTrending.php',
                    type:'POST',
                    beforeSend:function(){
                    $("#trendingPostsPagesLoading").show();
                    },
                    success:function(results) {
                        $("#trendingPostsPagesLoading").hide();
                        $("#trendingPostsPages").html(results);
                    }
                });
            }
            trendingPostsPages();
            </script>
          </div>
          </div>
          <!--==================[PeopleUMayKnow]===================-->
        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font color="#0000FF">Ad's</font></b>
        <br>
       <table width="300">
<tr>
<th>&nbsp;&nbsp;<a href="https://www.youthpeacemakers.or.tz/volunteering/"><img src="Volunteer8.jpg" width="295" /></a></th>
<tr>
<td><div align="center"><font color="#0000FF"><b>VOLUNTEERING</b><br>
Would you like to be a volunteer? Youth Peace Makers are welcoming both national and international volunteers for shorter and longer stays in our organization.
</font></div></td>
</tr>
</tr></table>
        <br>
        <table width="300">
<tr>
<th>&nbsp;&nbsp;<a href="http://j4peace.blogspot.com/p/peacemaking.html"><img src="12644842_1713788868854965_5109836926056022369_n.jpg" width="295" /></a></th>
<tr>
<td><div align="center"><font color="#0000FF">Peacemaking is the only path to true security for all, there will be no peace without justice. Peace has to be made between people, not only governments;</font></div></td>
</tr>
</tr></table>
        <br>
       <table width="300">
<tr>
<th>&nbsp;&nbsp;<a href="http://tasitanga.blogspot.com/p/kuhusu-tanga-social-innovators.html"><img src="9.JPG" width="295" /></a></th>
<tr>
<td><div align="center"><font color="#0000FF">Tanga Social Innovaters, Ni wajasiriamali jamii kutoka Tanga tunajishughulisha na shughuli mbalimbali. Za ujuzi na ubunifu wa vijana kama njia ya kujiajiri.</font></div></td>
</tr>
</tr></table>
        <br>
       <table width="300">
<tr>
<th>&nbsp;&nbsp;<a href="https://envaya.org/denyntz/projects"><img src="large.jpg" width="295" /></a></th>
<tr>
<td><div align="center"><font color="#0000FF">We are looking for partnership,
<br> local and international volunteering organization to be able to work together.</font></div></td>
</tr>
</tr></table>
        <br>
       <table width="300">
<tr>
<th>&nbsp;&nbsp;<a href="https://kfuk-kfum.no/om-oss/organisasjon/kfuk-kfum-bevegelsen/kfuk-kfum-global"><img src="Picture1.jpg" width="295" /></a></th>
<tr>
<td><div align="center"><font color="#0000FF">KFUK-KFUM Global er en kristen, økumenisk utviklings- og solidaritetsorganisasjon for internasjonalt diakoni eid av Norges KFUK-KFUM og Norges KFUK-KFUM-speidere.</font></div></td>
</tr>
</tr></table>
        <br>
       <table width="300">
<tr>
<th>&nbsp;&nbsp;<a href="http://j4peace.blogspot.com/p/stan-culture-producs.html"><img src="stanculture.png" width="295" /></a></th>
<tr>
<td><div align="center"><font color="#0000FF">STAN CULTURE
It is a product’s which I invented since 2009; I’m using things that can be seen as impurities in the community</font>
</div></td>
</tr>
</tr></table>
        <br>
       <table width="300">
<tr>
<th>&nbsp;&nbsp;<a href="http://j4peace.blogspot.com/p/peacemaking.html"><img src="Picture12.png" width="295" /></a></th>
<tr>
<td><div align="center"><b><font color="#0000FF">Join our movement</font></b></div></td>
</tr>
</tr></table>
        <br>
       <table width="300">
<tr>
<th>&nbsp;&nbsp;<a href="http://www.ronningen.fhs.no/linjene/ten-sing-norway.aspx"><img src="collage-diverse.jpeg" width="295" /></a></th>
<tr>
<td><div align="center"><font color="#0000FF">Ten Sing Norway er et ledertreningsprogram med en lang historie, i dag er programmet et samarbeid mellom Rønningen FHS og Norges KFUK-KFUM</font></div></td>
</tr>
</tr></table>
        <br>
       <table width="300">
<tr>
<th>&nbsp;&nbsp;<a href="http://makau2maker.blogspot.com/2015/09/peace-is-possible.html"><img src="IMG_20150921_115528.jpg" width="295" /></a></th>
<tr>
<td><div align="center"><font color="#0000FF"><h4><b>Peace is possible</b></h4></font></div></td>
</tr>
</tr></table>
        <br>
       
          </div>
        </div>
<!--====================================[ end Center col3 ]============================================-->
</div>
<!--===============================[ End ]==========================================-->
<script type="text/javascript">
$('.postContent_EditBox').each(function () {
  this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;text-align:' + "<?php echo lang('post_textbox_align'); ?>;");
}).on('input', function () {
  this.style.height = 'auto';
  this.style.height = (this.scrollHeight) + 'px';
});
$("#trPagesTab").click(function(){
$("#trPagesTab").css({"background": "#fff"});
$("#trPostsTab").css({"background": "#e9ebee"});
$("#trPages").show();
$("#trPosts").hide();
});
$("#trPostsTab").click(function(){
$("#trPostsTab").css({"background": "#fff"});
$("#trPagesTab").css({"background": "#e9ebee"});
$("#trPosts").show();
$("#trPages").hide();
});
</script>
<?php include "includes/endJScodes.php"; ?>
</body>
</html>
