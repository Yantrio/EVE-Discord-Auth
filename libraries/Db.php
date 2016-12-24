<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2016 Robert Sardinia
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 * @param $dir
 * @return null|PDO
 * @internal param null|string $db
 */
function openDB($dir)
{
    $db = $dir;

    $dsn = "sqlite:$db";
    try {
        $pdo = new PDO($dsn, '', '', array(
                PDO::ATTR_PERSISTENT => false,
                PDO::ATTR_EMULATE_PREPARES => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            )
        );
    } catch (Exception $e) {
        $pdo = null;
        return $pdo;
    }

    return $pdo;
}

/**
 * @param string $query
 * @param $dir
 * @param array $params
 * @internal param string $db
 */
function dbExecute($query, $dir, array $params = array())
{
    $pdo = openDB($dir);
    if ($pdo === NULL) {
        return;
    }

    // This is ugly, but, yeah..
    if (strstr($query, ';')) {
        $explodedQuery = explode(';', $query);
        $stmt = null;
        foreach ($explodedQuery as $newQry) {
            $stmt = $pdo->prepare($newQry);
            $stmt->execute($params);
        }
        $stmt->closeCursor();
    } else {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $stmt->closeCursor();
    }
}

function insertUser($db, $user, $pass, $dbName, $characterID, $corporationID, $allianceID, $authString, $active)
{

    $conn = new mysqli($db, $user, $pass, $dbName);

    $sql = "INSERT INTO pendingUsers (characterID, corporationID, allianceID, authString, active) VALUES ('$characterID','$corporationID','$allianceID','$authString','$active')";

    if ($conn->query($sql) === TRUE) {
        return null;
    } else {
        return null;
    }
}