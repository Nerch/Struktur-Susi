<?php

function listDirectory($dir, $prefix = '', $isLast = true) {
    $files = scandir($dir);
    $count = count($files);
    $i = 0;

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $i++;
            $isLastChild = ($i == $count - 2);
            $linePrefix = $prefix . ($isLast ? '    ' : '│   ');
            $filePrefix = $isLastChild ? '└── ' : '├── ';

            echo $prefix . $filePrefix . $file . "\n";

            if (is_dir($dir . '/' . $file)) {
                listDirectory($dir . '/' . $file, $linePrefix, $isLastChild);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Verzeichnisstruktur</title>
    <style>
        .container {
            display: flex;
        }
        .tree {
            flex: 1;
            white-space: pre;
        }
        .legend {
            flex: 1;
            padding-left: 20px;
        }

        @media print {
            .legend, button {
                display: none;
            }
            .tree {
                flex: 2; /* Erweitert den Baum im Druck */
                margin-left: 2cm; /* Fügt linken Rand für Notizen hinzu */
            }
            body {
                display: flex; /* Flexbox für den Body im Druck */
            }
            body::before {
                content: ""; /* Leerer Inhalt für Notizbereich */
                width: 4cm; /* Breite des Notizbereichs */
                border-right: 1px solid black; /* Trennlinie zum Baum */
                margin-right: 2cm; /* Abstand zwischen Notizbereich und Baum */
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="tree">
        <?php
        echo "<pre>";
        listDirectory(__DIR__);
        echo "</pre>";
        ?>
    </div>
    <div class="legend">
        <h2>Legende</h2>
        <p><span style="color: blue;">Blau</span>: Verzeichnis</p>
        <p><span style="color: green;">Grün</span>: Datei</p>
        <p><strong>Strukturelemente:</strong></p>
        <p>├── : Ordner/Datei</p>
        <p>└── : Letzter Ordner/Datei in einem Zweig</p>
        <p>│ : Vertikale Verbindungslinie</p>
        <p>Leerzeichen: Einrückung</p>
        <p><strong>Nutzung:</strong></p>
        <p>Dieses Skript zeigt die Verzeichnisstruktur des aktuellen Ordners an. Es verwendet Farben und Symbole, um Ordner und Dateien klar zu unterscheiden. Die Legende erklärt die Bedeutung der Farben und Symbole.</p>
        <button onclick="window.print()">Drucken</button>
    </div>
</div>

</body>
</html>
