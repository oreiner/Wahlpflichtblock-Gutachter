var submit_btn = document.createElement('input');
submit_btn.setAttribute('type', "submit");
submit_btn.setAttribute('name', "submit");
submit_btn.setAttribute('onclick', "return submit_form()");
submit_btn.setAttribute('value', "Kommentar hinzufügen");
var comment_form = document.getElementById("comment_form");
comment_form.appendChild(submit_btn);

function submit_form(){
	var text_checked = document.getElementById("comment_field_checkbox");
	var comment_text = document.getElementById("comment_text").value;
	var grade_checked = document.getElementById("grade_bar_checkbox");
	var did_grade = document.getElementById("Didaktik_Note");
	var auf_grade = document.getElementById("Auftreten_Note");
	var kr_grade = document.getElementById("Klinische_Relevanz_Note");
	var o_grade = document.getElementById("Organisation_Note");
	var grade1 = parseInt(did_grade.options[did_grade.selectedIndex].value);
	var grade2 = parseInt(auf_grade.options[auf_grade.selectedIndex].value);
	var grade3 = parseInt(kr_grade.options[kr_grade.selectedIndex].value);
	var grade4 = parseInt(o_grade.options[o_grade.selectedIndex].value);
	if (text_checked.checked){
		if(comment_text !== ""){
			if (grade_checked.checked){
				if(grade1 && grade2 && grade3 && grade4){
					comment_form.submit();
				} else {
					window.alert("Bitte bei allen Kriterien eine Note vergeben oder das Häckchen beim Kontrollkästchen entfernen!");
					return false;
				}
			} else {
					comment_form.submit();
			}
		} else {
			window.alert("Bitte einen Kommentar schreiben, oder das Häckchen beim Kontrollkästchen entfernen!");
			return false;
		}
	} else if (grade_checked.checked){
		if(grade1 && grade2 && grade3 && grade4){
			if (text_checked.checked){
				if(comment_text !== ""){
					comment_form.submit();
				} else {
					window.alert("Bitte einen Kommentar schreiben, oder das Häckchen beim Kontrollkästchen entfernen!");
					return false;
				}
			} else {
				comment_form.submit();
			}
		} else {
			window.alert("Bitte bei allen Kriterien eine Note vergeben oder das Häckchen beim Kontrollkästchen entfernen!");
			return false;
		}
	}
	else{
		window.alert("Bitte einen Kommentar schreiben und/oder Noten vergeben!");
		return false;
	}
}