# Wahlpflichtblock-Gutachter

Ein Austauschplattform über (z.B.) Wahlfächer.  
Die Studenten können Kurse bewerten, als Textkommentar und/oder eine Note vergeben.  
Die Kommentare müssen erst von Moderatoren freigegeben werden, um Spam und misbrauch vorzubeugen.  
Die Seite erlaubt die hierarchische Zuordnung von einzelne Themen (Kurse) in Categorien (Fach) für leichtere Navigation.  

## Einstellung:

leider gibt es noch kein config Datei, das heißt man muss die einzelne Dateien finden und anpassen:

### Server interpertation von URLs
/.htaccess muss je nach Hosting angepasst werden 

### Backend

1. Datenbank erstellen
>vorlage_WPB.sql in phpmyadmin importieren

2. Einstellung von database server, user, password, name
>/includes/db_connection

### Frontend
Inhalte anpassen: E-Mail-Adresse, Text etc.
>/public/index.php

*Der Admin-Frontend ist leider noch nicht zur neuen Version der Seite angepasst, d.h. man muss Kurse (neue hinzufügen) vom phpmyadmin verwalten.  
Freigeben von Kommentare klappt. 
