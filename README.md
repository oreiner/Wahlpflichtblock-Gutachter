# Wahlpflichtblock-Gutachter

Ein Austauschplattform über (z.B.) Wahlfächer.
Die Studenten können Kurse bewerten, als Textkommentar und/oder eine Note vergeben.
Die Kommentare müssen erst von Moderatoren freigegeben werden, um Spam und misbrauch vorzubeugen.
Die Seite erlaubt die hierarchische Zuordnung von einzelne Themen (Kurse) in Categorien (Fach) für leichtere Navigation.

## Einstellung:

leider gibt es noch kein config Datei, das heißt die einzelne Dateien sind zu finden und anpassen:

### Server interpertation von URLs
/.htaccess muss je nach Hosting angepasst werden 

### Backend
1.
/includes/db_connection
database server, user, password, name

2. Datenbank erstenn
>vorlage_WPB.sql in phpmyadmin importieneren

### Frontend
/public/index.php
E-Mail-Adresse
Text etc.
