<?php 
// font: http://www.cristalab.com/tutoriales/como-crear-un-feed-rss-con-mysql-y-php-c82325l/
// utilitzarem com a font de dades la taula noticies del portal web de l'assignatura, sino cal adaptar-ho, adapteu el nom de BBDD user i pass

header('Content-type: text/xml; charset="iso-8859-1"', true);
echo '';

?>
<?xml version="1.0" encoding="iso-8859-1"?> 
<rss version="2.0">
    <channel>
        <title>RSS FacturEye</title>
        <link>http://localhost/ProjecteFinal/CodeIgniter-3.1.8</link>
        <description>Exemple us dels RSS.</description>
        <language>es</language>
        <?php
            mysql_connect("localhost","root","");
            mysql_select_db("factureye");
            $result = mysql_query ("SELECT * FROM noticies_externes ORDER BY data desc LIMIT 0,20") or die (mysql_error());
            while ($row = mysql_fetch_array ($result)) {
        ?>
        <item>
            <title><?php echo $row['titol_noticia'] ?></title>
            <pubDate><?php echo $row['data'] ?></pubDate>
            <description><?php echo $row['noticia'] ?></description>
        </item>
        <?php }
        mysql_free_result ($result);
        ?>
    </channel>
</rss>