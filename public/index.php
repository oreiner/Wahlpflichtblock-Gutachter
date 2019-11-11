<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include_once("../includes/analyticstracking.php") ?>

<?php $layout_context = "public"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_comment(true); ?>
<div id="main" class="clearfix">
  <div id="navigation">
		<?php echo public_navigation($current_subject, $current_course); ?>
		<br />
		<!--<?php // echo public_image_navigation($current_exam_subject, $current_image); ?>
		<br />-->
		<?php echo public_histogram_navigation($current_histogram_subject); ?>
  </div>

  <div id="page">
		<?php if ($current_course) { ?>
			<h2><?php echo ($current_course["course_name"]);?></h2>
			<table class="grades_table">
				<thead>
					<th>Gesamtnote</th>
					<th>Didaktik</th>
					<th>Auftreten</th>
					<th>Klinische Relevanz</th>
					<th>Organisation</th>
					<th>Stimmen</th>
				</thead>
				<tbody><tr>
				<?php
					$course_grades = find_grades_for_course($current_course["id"]);
					if($grade = mysqli_fetch_assoc($course_grades)) {?>
						<td><?php echo htmlentities(number_format($grade["AVG(Gesamtnote)"], 2, ",", "."));?></td>
						<td><?php echo htmlentities(number_format($grade["AVG(Didaktik)"], 2, ",", "."));?></td>
						<td><?php echo htmlentities(number_format($grade["AVG(Auftreten)"], 2, ",", "."));?></td>
						<td><?php echo htmlentities(number_format($grade["AVG(Klinische_Relevanz)"], 2, ",", "."));?></td>
						<td><?php echo htmlentities(number_format($grade["AVG(Organisation)"], 2, ",", "."));?></td>
						<td><?php echo htmlentities($grade["COUNT(*)"]);?></td>
				<?php	
					}	
				?>
				</td></tr></tbody>
			</table><br />
			<form action="create_comment.php" method="post" class="new_comment_form" id="comment_form"><b><u>Neuen Kommentar hinzufügen:</u></b>
				<p>Benutzername: <input type="text" name="user_name" id="user_name" value="" placeholder="Benutzername"></p>
				<p>Fachsemester: <select name="Fachsemester" id="Fachsemester">
					<?php for ($i = 1; $i <= 10; $i++) : ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select> (In dem du warst, als du den Kurs absolviert hast)</p>
				<p>WPB-Semester: <select name="WPBsemester" id="WPBsemester" value="WS 2016/17"> 
					<?php for ($i = 2010, $year = date("Y"), $month = date("m"); $i <= $year ; $i++) : ?>
						<?php $j = $i-1999 /*default value is WS when current month is januar until may*/?>
						<option value="<?php echo "WS ".$i."/".$j; ?>" <?php if($i == $year-1 && $month <= 5){echo "selected";}?>><?php echo "WS ".$i."/".$j; ?></option> 
						<option value="<?php echo "SS ".($i+1); ?>" <?php if(($i+1) == $year && $month > 5){echo "selected";}?>><?php echo "SS ".($i+1); ?></option>	
					<?php endfor; ?>
				</select> (das Jahr, in dem du an dem WPB teilgenommen hast)</p>
				<input type="checkbox" id="comment_field_checkbox" class="comment_field_checkbox" value=1 checked>Ich möchte einen Kommentar hinterlassen</input>
				<p id="comment_field" class="comment_field">Kommentar:<br />
					<textarea id="comment_text" name="content" rows="6" cols="82" placeholder="Tipps wie man einen guten Kommentar schreibt, findest du auf der Startseite!"></textarea>
				</p><br />
				<input type="checkbox" id="grade_bar_checkbox" class="grade_bar_checkbox" name="notes" value=1 checked>Ich möchte eine Benotung vergeben</input>
				<p id="grade_bar" class="grade_bar">
					Didaktik: <select id="Didaktik_Note" name="Didaktik_Note">
						<option value=0><?php echo "-"; ?></option>
						<?php for ($i = 1; $i <= 6; $i+=0.5) : ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
					</select>
					Auftreten: <select id="Auftreten_Note" name="Auftreten_Note">
						<option value=0><?php echo "-"; ?></option>
						<?php for ($i = 1; $i <= 6; $i+=0.5) : ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
					</select>
					Klinische Relevanz: <select id="Klinische_Relevanz_Note" name="Klinische_Relevanz_Note">
						<option value=0><?php echo "-"; ?></option>
						<?php for ($i = 1; $i <= 6; $i+=0.5) : ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
					</select>
					Organisation: <select id="Organisation_Note" name="Organisation_Note">
						<option value=0><?php echo "-"; ?></option>
						<?php for ($i = 1; $i <= 6; $i+=0.5) : ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
					</select>
				</p><br />
				<input type="hidden" name="id" value="<?php echo $current_course["id"]; ?>">
<input type="hidden" name="source" value="Website">
				<script type="text/javascript" src="javascripts/submit_comment.js"></script> <!-- insert submit button -->
				
			</form><br />
			<table class="comments_table"><tbody>	
				<?php 	
					$course_comments = find_comments_for_course($current_course["id"]);
					while($comment = mysqli_fetch_assoc($course_comments)) {
					?><tr><?php echo $box_style = ($comment["user_name"] == "Klips2")? "<td class=\"klips_text\">" : "<td class=\"text\">"; ?> 
						<small><?php echo $comment["user_name"];?></small><br />
						<small>Fachsemester: <?php echo $comment["Fachsemester"];?></small><br />
						<small>WPB-Semester: <?php echo $comment["WPBsemester"];?></small><br />
						<?php echo $comment_placeholder = $comment["visible"] ? nl2br("\n".$comment["content"]."\n") : nl2br("\nDanke für deinen Kommentar. Der Kommentar wartet auf Bestätigung vonseiten der Verwaltung\n"); ?><br />
						<small><?php 
							$comment_grades = find_grades_for_comment($comment["id"]);
							if($grades = mysqli_fetch_assoc($comment_grades)){ 
								echo "Gesamtnote: ".number_format($grades["Gesamtnote"], 2, ",", ".")."<br />"; 
								echo " Didaktik: ".number_format($grades["Didaktik"], 2, ",", ".");
								echo " Auftreten: ".number_format($grades["Auftreten"], 2, ",", "."); 
								echo " Klinische Relevanz: ".number_format($grades["Klinische_Relevanz"], 2, ",", "."); 
								echo " Organisation: ".number_format($grades["Organisation"], 2, ",", ".")."<br /><br />"; 
							}?>
						</small>
						<small><?php echo $comment["comment_date"];?></small>
					</td></tr>
					<tr><td class="missbrauch"><button onClick="reportAbuse(<?php echo $comment["id"] ?>)" id="missbrauch_button_<?php echo $comment["id"] ?>" class="missbrauch"><small>Missbrauch melden</small></button></td></tr>
					<?php
					}
				?>	
			</tbody></table>
			
		<?php } elseif ($current_exam_subject){ ?>	
			<h3>Fach: <?php echo htmlentities(str_replace("_"," ",$current_exam_subject)); ?></h3><br />
			<?php 
				$image_set = format_images_for_subject("{$current_exam_subject}");
				foreach($image_set as $image){
					echo str_replace("_"," ",substr($image,0,-4)); ?><br />
					<img src="images/<?php echo $current_exam_subject . "/" . $image; ?>" class="grade">
					<br />
		<?php 
				}
			} elseif ($current_histogram_subject) { ?>
			<h3>Fach: <?php echo htmlentities(str_replace("_"," ",$current_histogram_subject)); ?></h3><br />
			<?php 
				$histogram_set = find_histograms_for_subject("{$current_histogram_subject}"); ?>
<img src="exam_avg.php?Fach=<?php echo $current_histogram_subject?>">
<?php
				foreach($histogram_set as $histogram){	
			?>
					<img src="exam_graph.php?Fach=<?php echo $current_histogram_subject?>&Semester=<?php echo $histogram["Semester"];?>">
					<br />
		<?php	}
			} else { ?>
			<h1 style="color:red;">Achtung! Die URL lautet ab sofort wpbgutachter.DE nicht .xyz!</h1><h2 style="color:red;">Lesezeichen aktualisieren!</h2>
			<h1>Willkommen!</h1>
			<p>Such dir einen Kurs aus dem Menü auf der linken Seite aus, lese die Kommentare und Noten dazu!</p><br /><br />
			<p>Die Bewertung der Lernveranstaltungen erfolgt nach deutschem Schulnotensystem (1= sehr gut, 6= ungenügend) und wird in vier Kategorien unterschieden: </p><br />
			<ul>
				<li><b>Didaktik: </b>Die Didaktik der Veranstaltung/des Dozenten (Strukturierung, Verständlichkeit, Folien, etc.) war gut. Man hat bei der Veranstaltung viel gelernt.</li><br />
				<li><b>Auftreten: </b>Das Auftreten des/der Dozenten im Umgang mit Patienten, Einbindung der Studierenden, persönliches Engagement des/der Dozenten/in.</li><br />
				<li><b>Klinische Relevanz: </b>Die Lernveranstaltung war praxisorientiert bzw. man konnte viel Wissen oder Fertigkeiten erlernen, die man später in der klinischen Tätigkeit anwenden kann.</li><br />
				<li><b>Organisation: </b> Die Lernveranstaltung wurde gut verwaltet (alle Dozenten sind pünktlich gekommen, keine Unterrichtsausfälle, Folien wurden hochgeladen, etc.).</li>
			</ul><br />

			<h3>Wie schreibe ich einen guten Kommentar?</h3>
			<p>Folgende Punkte solltest du bei deiner Bewertung beachten:</p>
			<ol>
				<li>In welchem Fachsemester hast du den Kurs absolviert, wäre dieser für andere Semester auch/besser geeignet?</li><br />
				<li>Welche Form hat der Kurs: Wurden praktische Fertigkeiten beigebracht? War der Kurs eher eine theoretische Vorlesung/Diskussion?</li><br />
				<li>Wie zeitintensiv war der Kurs? War er semesterbegleitend oder fand er zum Ende des Semesters statt?</li><br />
				<li>Hat dir der Kurs Spaß gemacht? Wie war der Lernerfolg?</li><br />
				<li>Würdest du den Kurs insgesamt weiterempfehlen oder davon abraten?</li><br />
				<li>Weitere Informationen, die andere Studierende interessieren könnten.</li><br />
			</ol><br />
			<p><h3>Notenspiegel</h3>
			Es gibt auf dieser Seite eine weitere Funktion: Ihr könnt die Notenspiegel der letzten Klausuren aufrufen.<br />
			Vielleicht hilft das dem Einen oder Anderen die Angst vor der Klausur abzubauen. ;) </p> 
			<br />
			
			
			<p><h3>Haftungsausschluss:</h3> Bitte beachte, dass diese Website dem freundlichen Austausch Über das Wahlpflichtblockangebot unserer Fakultät dient. <br />
			Die Website-Verwaltung Übernimmt keine Haftung für die Informationen die hier enthalten sind.<br />
			Mehr zu den AGB findest du hier: <a href="agb.php"><i>AGB</i></a></p>
			<br /><br /><br /><br />
				<small>Fragen? Anregungen? Schick uns eine E-Mail an [E-MAIL-ADDRESSE] </small>

			
		<?php }?>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

<script>
function reportAbuse(id) {
	var txt;
    var r = confirm("Möchtest du diese Nachricht melden?");
    if (r == true) {
		var xhttp;
		xhttp = new XMLHttpRequest();
		
		xhttp.open("GET", "create_report.php?course="+"<?php echo $current_course["id"]; ?>"+"&comment_id="+id+"&source=Missbrauch"+"&submit=1", true);
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
			}
		}
		xhttp.send();
    } 
}
</script>









<!--


<script>
function reportAbuse(id) {
	var txt;
    var r = confirm("Möchtest du diese Nachricht melden?");
    if (r == true) {
		var xhttp;
		xhttp = new XMLHttpRequest();
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.open("POST", "create_report.php?", true);
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
			}
		}
		xhttp.send("course="+"<?php echo $current_course["id"]; ?>"+"&comment_id="+id+"&source=Missbrauch"+"&submit=1");
    } 
}
</script>



function reportAbuse(id) {
	var txt;
    var r = confirm("Möchtest du diese Nachricht melden?");
    if (r == true) {
		var xhttp;
		xhttp = new XMLHttpRequest();
		xhttp.open("POST", "create_report.php?course="+"<?php echo $current_course["id"]; ?>"+"&comment_id="+id, true);
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
			}
		}
		xhttp.send(course="<?php echo $current_course["id"]?>", comment_id=id, source="Missbrauch");
    } 
}