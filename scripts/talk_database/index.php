<?php

$prepareContent=prepareContent();
saveContent($prepareContent);



function connection(): \PDO
{
     $dsn = 'mysql:dbname=crane;port=3306;host=test-serv.fc-sistema.com';

    try {
        $PDO = new PDO($dsn, 'chat_bot', "!QAZchat2wsx");
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $PDO->exec("SET NAMES utf8");
        $PDO->exec("SET character set utf8");
        $PDO->exec("SET character_set_connection='utf8'");

        return $PDO;
    } catch (\PDOException $e) {
        echo $e->getMessage() . "\n";
        echo $e->getLine();

        return $PDO = null;
    }
}

function prepareContent()
{
    $content = file_get_contents('file.txt');

    $arrContent = explode("\n", $content);

    $prepareContent = [];
    foreach ($arrContent as $key=>$unit) {
        $manyUnits = explode("\\", mb_strtolower($unit));

        if (!empty($manyUnits[0]) and !empty($manyUnits[1])) {
            $prepareContent[] = [$manyUnits[0], $manyUnits[1]];
        }
    }

    return $prepareContent;
}

function saveContent(array $prepareContent)
{
    $pdo = connection();

    $sql =/**@lang text*/
        'insert into talk (status, question, answer) values';

    foreach ($prepareContent as $key=>$itemContent) {
        $sql.= "(1, :question{$key}, :answer{$key}),";
    }

    $sth = $pdo->prepare(rtrim($sql, ','));

    foreach ($prepareContent as $key=>$itemContent) {
        $sth->bindParam(":question{$key}",$itemContent[0]);
        $sth->bindParam(":answer{$key}",$itemContent[1]);
    }

    $sth->execute();
}

