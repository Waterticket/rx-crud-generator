<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="XE/Rhymix용 DB CRUD 생성기입니다.">
        <meta name="keywords" content="XpressEngine, XE, Rhymix, CRUD">
        <meta name="author" content="Waterticket">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rhymix CRUD Generator</title>
        <style>
        html {
            font-family: 'D2Coding';
            src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_three@1.0/D2Coding.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }

        textarea {
            max-width: 1200px;
            width: 100%;
            height: 300px;
        }

        pre {
            background: #f5f7ff;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type=submit] {
            padding: 8px;
            border: 3px solid #ccc;
            border-radius: 4px;
            background: #ccc;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
        }

        input[type=button] {
            padding: 8px;
            border: 3px solid #ccc;
            border-radius: 4px;
            background: #ccc;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
        }

        section#result {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        section#result > div {
            padding: 16px;
            border: 1px solid #e1e1e1;
        }

        @media screen and (max-width: 1000px) {
            section#result {
                grid-template-columns: 1fr;
            }

            pre {
                font-size: 1em;
            }
        }

        @media screen and (max-width: 1920px) {
            pre {
                font-size: 1em;
            }
        }

        table.help tr {
            border: 1px solid black !important;
        }
        
        table.help input {
            width: 200px;
            height: 20px;
        }

        footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-bottom: 20px;
        }

        #code-example {
            display: none;
        }

        #code-example.display {
            display: block;
        }

        /* Toast Notification by Fineshop */
        .tNtf span{position:fixed;left:24px;bottom:-70px;display:inline-flex;align-items:center;text-align:center;justify-content:center;margin-bottom:20px;z-index:99981;background:#323232;color:rgba(255,255,255,.8);font-size:14px;font-family:inherit;border-radius:3px;padding:13px 24px; box-shadow:0 5px 35px rgba(149,157,165,.3);opacity:0;transition:all .1s ease;animation:slideinwards 2s ease forwards;-webkit-animation:slideinwards 2s ease forwards}
        @media screen and (max-width:500px){.tNtf span{margin-bottom:20px;left:20px;right:20px;font-size:13px}}
        @keyframes slideinwards{0%{opacity:0}20%{opacity:1;bottom:0}50%{opacity:1;bottom:0}80%{opacity:1;bottom:0}100%{opacity:0;bottom:-70px;visibility:hidden}}
        @-webkit-keyframes slideinwards{0%{opacity:0}20%{opacity:1;bottom:0}50%{opacity:1;bottom:0}80%{opacity:1;bottom:0}100%{opacity:0;bottom:-70px;visibility:hidden}}
        .darkMode .tNtf span{box-shadow:0 10px 40px rgba(0,0,0,.2)}
        </style>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/styles/base16/atelier-sulphurpool-light.min.css">
    </head>
<body>

<h1>Rhymix CRUD Generator</h1>
<p>XE/라이믹스에서 매번 만들기 귀찮은 DB CRUD 쿼리를 자동으로 생성해줍니다.</p>

<form method="POST" id="codeplace">
<textarea id="code_input" name="code" placeholder="XML Scheme를 입력해주세요" spellcheck="false" required="required"><?=htmlspecialchars($_REQUEST['code'])?></textarea><br><br>
<table class="help">
<tr>
    <td colspan="3"><hr></td>
</tr>
<tr>
    <td style="padding-left: 16px;">쿼리 이름</td>
    <td style="padding-left: 16px;"><input type="text" name="query_name" placeholder="쿼리 이름" value="<?=$_REQUEST['query_name']?>"></td>
    <td style="padding-left: 16px;"><span style="color: #666">insert{쿼리명}, get{쿼리명}, delete{쿼리명}과 같이 쿼리명 부분에 들어갈 단어입니다. <br>기본적으로 입력하지 않아도 상관없으나, 테이블의 언더바 뒤 제일 마지막 단어가 복수형 단어인 경우, 여기에 단수형 단어를 입력해주세요.<br>ex) 테이블명이 hotoboard_documents 일 경우, document 입력.</span></td>
</tr>
<tr>
    <td colspan="3"><hr></td>
</tr>
<tr>
    <td style="padding-left: 16px;">모듈 이름</td>
    <td style="padding-left: 16px;"><input type="text" name="module_name" placeholder="모듈 이름" value="<?=$_REQUEST['module_name']?>"></td>
    <td style="padding-left: 16px;"><span style="color: #666">모듈의 이름을 입력해주세요. 미 입력시 기본적으로 테이블 언더바 기준 제일 첫번째 글자가 사용됩니다.<br>ex) 미입력시 테이블명이 hotoboard_documents 일 경우, hotoboard 사용.</span></td>
</tr>
<tr>
    <td colspan="3"><hr></td>
</tr>
<tr>
    <td style="padding-left: 16px;">검색 조건 컬럼</td>
    <td style="padding-left: 16px;"><input type="text" name="condition_key" placeholder="검색 조건에 들어갈 컬럼" value="<?=$_REQUEST['condition_key']?>"></td>
    <td style="padding-left: 16px;"><span style="color: #666">Primary Key 대신에 검색 조건에 넣고싶은 컬럼을 입력해주세요. 여러개는 ',' 콤마로 구분됩니다. <br>미입력시 Primary Key 속성을 가진 컬럼이 condition절에 들어갑니다.</span></td>
</tr>
<tr>
    <td colspan="3"><hr></td>
</tr>
</table>
<br>
<p style="color:red">※ 코드창에서 <b>Ctrl+Enter</b> 혹은 <b>Ctrl+S</b> 입력시 자동 Submit 됩니다.</p>
<input type="submit" value="Generate">
</form>
<br>
<br>

<script>
document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('code_input').addEventListener('keydown', function (e){
        // if press ctrl+enter
        if ((event.keyCode == 10 || event.keyCode == 13) && event.ctrlKey)
        {
            document.getElementById('codeplace').submit();
        }

        // if press ctrl+s
        if (event.ctrlKey && event.keyCode == 83) {
            event.preventDefault();
            document.getElementById('codeplace').submit();
        }
    }, false);
});
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<?php
date_default_timezone_set('Asia/Seoul');

$myXMLData = $_REQUEST['code'];
if(empty($myXMLData)) die;

$xml=simplexml_load_string($myXMLData) or die("Error: Cannot create object");

$table_name = $xml['name'];
if(!empty($_REQUEST['query_name']))
{
    $table_short_name = ucfirst($_REQUEST['query_name']);
}
else
{
    $table_short_name = explode('_', $table_name);
    $table_short_name = ucfirst($table_short_name[count($table_short_name)-1]);
}

if(!empty($_REQUEST['module_name']))
{
    $module_name = $_REQUEST['module_name'];
}
else
{
    $module_name = explode('_', $table_name);
    $module_name = $module_name[0];
}

$condition_key = array();
if(!empty($_REQUEST['condition_key']))
{
    $condition_key = explode(',', $_REQUEST['condition_key']);
    foreach($condition_key as $key => $value)
    {
        $condition_key[$key] = trim($value);
    }
}
else
{
    foreach($xml->children() as $column) {
        if($column['primary_key'] == 'primary_key')
        {
            $condition_key[] = $column['name'];
        }
    }
}

include("includes/inflect.php");
function pluralize($word) {
    return Inflect::pluralize($word);
}
?>

<section id="result">
<div>
<hr>
<p style="color:red">※ 코드를 <b>더블 클릭하면</b> 클립보드로 복사됩니다.</p>
<input type="button" value="Download xml files in zip" onclick="downloadByZip()">
<p>※ xml 파일을 /modules/<?=$module_name?>/queries 폴더 아래에 넣어주세요.</p>
<br>
<br>
<b>Create:</b>
<div class="codes">
<p>insert<?=$table_short_name?>.xml</p>
<pre><code class="xml">&lt;query id="insert<?=$table_short_name?>" action="insert">
    &lt;tables>
        &lt;table name="<?=$table_name?>" />
    &lt;/tables>
    &lt;columns>
<?php
foreach($xml->children() as $column) {
    if (!isset($column["auto_increment"]))
    {
        echo '        &lt;column name="'.$column['name'].'" var="'.$column['name'].'" '.(((isset($column['notnull']) || isset($column['primary_key'])) && (($column['name'] != 'regdate') && ($column['name'] != 'register_date') && ($column['name'] != 'ipaddress'))) ? 'notnull="notnull" ' : '').(($column['name'] == 'regdate' || $column['name'] == 'register_date') ? 'default="curdate()" ' : '').(($column['name'] == 'ipaddress') ? 'default="ipaddress()" ' : '').'/>'."\r\n";
    }
}
?>
    &lt;/columns>
&lt;/query>
</code></pre>
</div>
<hr><br>

<b>Read:</b>
<div class="codes">
<p>get<?=$table_short_name?>.xml</p>
<pre><code class="xml">&lt;query id="get<?=$table_short_name?>" action="select">
    &lt;tables>
        &lt;table name="<?=$table_name?>" />
    &lt;/tables>
    &lt;columns>
        &lt;column name="*" />
    &lt;/columns>
    &lt;conditions>
<?php
$i = 0;
foreach($xml->children() as $column) {
    if(in_array($column['name'], $condition_key))
    {
        echo '            &lt;condition operation="equal" column="'.$column['name'].'" var="'.$column['name'].'" filter="'.$column['type'].'"'.(($i > 0) ? ' pipe="and"' : '').' />'."\r\n";
        $i++;
    }
}
?>
    &lt;/conditions>
&lt;/query>
</code></pre>
</div>

<div class="codes">
<p>get<?=pluralize($table_short_name)?>.xml</p>
<pre><code class="xml">&lt;query id="get<?=pluralize($table_short_name)?>" action="select">
    &lt;tables>
        &lt;table name="<?=$table_name?>" />
    &lt;/tables>
    &lt;columns>
        &lt;column name="*" />
    &lt;/columns>
    &lt;conditions>
<?php
$i = 0;
foreach($xml->children() as $column) {
    if(in_array($column['name'], $condition_key))
    {
        echo '            &lt;condition operation="in" column="'.$column['name'].'" var="'.$column['name'].'" filter="'.$column['type'].'"'.(($i > 0) ? ' pipe="and"' : '').' />'."\r\n";
        $i++;
    }
}
?>
    &lt;/conditions>
&lt;/query>
</code></pre>
</div>

<div class="codes">
<p>get<?=$table_short_name?>List.xml</p>
<pre><code class="xml">&lt;query id="get<?=$table_short_name?>List" action="select">
    &lt;tables>
        &lt;table name="<?=$table_name?>" />
    &lt;/tables>
    &lt;columns>
        &lt;column name="*" />
    &lt;/columns>
    &lt;conditions>
<?php
$priamary_key = '';
$i = 0;
foreach($xml->children() as $column) {
    if(in_array($column['name'], $condition_key))
    {
        if($priamary_key == '') $priamary_key = $column['name'];
        echo '            &lt;condition operation="equal" column="'.$column['name'].'" var="'.$column['name'].'" filter="'.$column['type'].'"'.(($i > 0) ? ' pipe="and"' : '').' />'."\r\n";
        $i++;
    }
}
?>
    &lt;/conditions>
    &lt;navigation>
        &lt;index var="sort_index" default="<?=$priamary_key?>" order="order_type" />
        &lt;list_count var="list_count" default="20" />
        &lt;page_count var="page_count" default="10" />
        &lt;page var="page" default="1" />
    &lt;/navigation>
&lt;/query>
</code></pre>
</div>
<hr><br>

<b>Update:</b>
<div class="codes">
<p>update<?=$table_short_name?>.xml</p>
<pre><code class="xml">&lt;query id="update<?=$table_short_name?>" action="update">
    &lt;tables>
        &lt;table name="<?=$table_name?>" />
    &lt;/tables>
    &lt;columns>
<?php
foreach($xml->children() as $column) {
    // if(!isset($column['primary_key']) || $column['primary_key'] != 'primary_key')
    if(!in_array($column['name'], $condition_key))
    {
        echo '            &lt;column name="'.$column['name'].'" var="'.$column['name'].'" />'."\r\n";
    }
}
?>
    &lt;/columns>
    &lt;conditions>
<?php
$i = 0;
foreach($xml->children() as $column) {
    if(in_array($column['name'], $condition_key))
    {
        echo '            &lt;condition operation="equal" column="'.$column['name'].'" var="'.$column['name'].'" filter="'.$column['type'].'" notnull="notnull"'.(($i > 0) ? ' pipe="and"' : '').' />'."\r\n";
        $i++;
    }
}
?>
    &lt;/conditions>
&lt;/query>
</code></pre>
</div>
<hr><br>

<b>Delete:</b>
<div class="codes">
<p>delete<?=$table_short_name?>.xml</p>
<pre><code class="xml">&lt;query id="delete<?=$table_short_name?>" action="delete">
    &lt;tables>
        &lt;table name="<?=$table_name?>" />
    &lt;/tables>
    &lt;conditions>
<?php
$i = 0;
foreach($xml->children() as $column) {
    if(in_array($column['name'], $condition_key))
    {
        echo '            &lt;condition operation="equal" column="'.$column['name'].'" var="'.$column['name'].'" filter="'.$column['type'].'" notnull="notnull"'.(($i > 0) ? ' pipe="and"' : '').' />'."\r\n";
        $i++;
    }
}
?>
    &lt;/conditions>
&lt;/query>
</code></pre>
</div>
<hr><br>
</div>
<div>
<hr>
<?php
function column_type_to_php($type)
{
    switch($type)
    {
        case 'int':
            return 'int';
        case 'number':
            return 'int';
        case 'varchar':
            return 'string';
        case 'text':
            return 'string';
        case 'datetime':
            return 'string';
        case 'date':
            return 'string';
        case 'time':
            return 'string';
        case 'timestamp':
            return 'string';
        case 'float':
            return 'float';
        case 'double':
            return 'float';
        case 'decimal':
            return 'float';
        case 'blob':
            return 'string';
        case 'enum':
            return 'string';
        case 'set':
            return 'string';
        case 'bit':
            return 'int';
        case 'bool':
            return 'int';
        case 'tinyint':
            return 'int';
        case 'smallint':
            return 'int';
        case 'mediumint':
            return 'int';
        case 'bigint':
            return 'int';
        case 'char':
            return 'string';
        case 'varchar':
            return 'string';
        case 'tinytext':
            return 'string';
        case 'text':
            return 'string';
        case 'mediumtext':
            return 'string';
        case 'longtext':
            return 'string';
        case 'tinyblob':
            return 'string';
        case 'mediumblob':
            return 'string';
        case 'longblob':
            return 'string';
        case 'binary':
            return 'string';
        case 'varbinary':
            return 'string';
        case 'enum':
            return 'string';
        case 'set':
            return 'string';
        case 'geometry':
            return 'string';
        case 'point':
            return 'string';
        default:
            return $type;
    }
}

function generate_random_by_type($type)
{
    switch($type)
    {
        case 'int':
            return rand(0, 100000);
        case 'float':
            return round(rand(0, 100000) / 7, 2);
        case 'string':
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '"';
            for ($i = 0; $i < 10; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $randomString .= '"';
            return $randomString;
        default:
            return rand(0, 1000000);
    }
}
?>
<p><b>PHP Code:</b></p>
<p>/modules/<?=$module_name?>/<?=$module_name?>.model.php 파일 내부 클래스에 넣고 사용하시면 됩니다. 사용 예시는 <a href="javascript:void(0)" onclick="document.getElementById('code-example').classList.toggle('display')">다음과 같습니다.</a></p>
<?php
$param = '';
$i = 0;
foreach($xml->children() as $column)
{
    if(in_array($column['name'], $condition_key))
    {
        if($i != 0)
        {
            $param .= ', ';
        }
        $param .= '$'.$column['name'];
        $i++;
    }
}
?>
<div id="code-example">
<pre><code class="php">/*
 * <?=$table_name?> 테이블에서 <?=$table_short_name?>를 가져오는 예시코드 입니다.
 */

$o<?=ucfirst($module_name)?>Model = getModel('<?=$module_name?>'); // <?=$module_name?>.model.php를 불러옵니다.

// 불러오고자 하는 데이터를 설정합니다.
<?php
foreach($xml->children() as $column)
{
    if(in_array($column['name'], $condition_key))
    {
        echo '$'.$column['name']." = ".(generate_random_by_type(column_type_to_php($column['type']))).";\r\n";
        $i++;
    }
}
?>
$<?=$table_short_name?> = $o<?=ucfirst($module_name)?>Model->get<?=$table_short_name?>(<?=$param?>); // 값을 DB에서 가져옵니다.

debugPrint($<?=$table_short_name?>); // 값을 디버그 페이지에 표시합니다.
</code></pre>
</div>
<br>
<pre><code class="php">/**
 * <?=$table_name?> 테이블에 <?=$table_short_name?> 하나를 추가한다.
 * 
 * @param object $obj
 */
public static function insert<?=$table_short_name?>(object $obj): object
{
    $oDB = DB::getInstance();
    $oDB->begin();

    $output = executeQuery('<?=$module_name?>.insert<?=$table_short_name?>', $obj);
    if(!$output->toBool())
    {
        $oDB->rollback();
        throw new \Rhymix\Framework\Exceptions\DBError(sprintf("DB Error: %s in %s line %s", $output->getMessage(), __FILE__, __LINE__));
    }
    $oDB->commit();

    return new BaseObject();
}

<?php
$param = '';
$comment = '';
$i = 0;
foreach($xml->children() as $column)
{
    if(in_array($column['name'], $condition_key))
    {
        if($i != 0)
        {
            $param .= ', ';
        }
        $param .= column_type_to_php($column['type']).' $'.$column['name'];
        $comment .= ' * @param '.column_type_to_php($column['type']).' $'.$column['name']."\r\n";
        $i++;
    }
}
?>
/**
 * <?=$table_name?> 테이블에서 <?=$table_short_name?>를 가져온다.
 * 
<?=$comment?> */
public static function get<?=$table_short_name?>(<?=$param?>): object
{
    $args = new \stdClass();
<?php
foreach($xml->children() as $column)
{
    if(in_array($column['name'], $condition_key))
    {
        echo '    $args->'.$column['name'].' = $'.$column['name'].';'."\r\n";
    }
}
?>

    $output = executeQuery('<?=$module_name?>.get<?=$table_short_name?>', $args);
    if(!$output->toBool())
    {
        throw new \Rhymix\Framework\Exceptions\DBError(sprintf("DB Error: %s in %s line %s", $output->getMessage(), __FILE__, __LINE__));
    }

    return $output->data;
}

<?php
$param = '';
$comment = '';
$i = 0;
foreach($xml->children() as $column)
{
    if(in_array($column['name'], $condition_key))
    {
        if($i != 0)
        {
            $param .= ', ';
        }
        $param .= 'array $'.$column['name'];
        $comment .= ' * @param '.'array'.' $'.$column['name']."\r\n";
        $i++;
    }
}
?>
/**
 * <?=$table_name?> 테이블에서 <?=$table_short_name?> 여러 건을 가져온다.
 * 
<?=$comment?> */
public static function get<?=pluralize($table_short_name)?>(<?=$param?>): array
{
    $args = new \stdClass();
<?php
foreach($xml->children() as $column)
{
    if(in_array($column['name'], $condition_key))
    {
        echo '    $args->'.$column['name'].' = $'.$column['name'].';'."\r\n";
    }
}
?>

    $output = executeQueryArray('<?=$module_name?>.get<?=pluralize($table_short_name)?>', $args);
    if(!$output->toBool())
    {
        throw new \Rhymix\Framework\Exceptions\DBError(sprintf("DB Error: %s in %s line %s", $output->getMessage(), __FILE__, __LINE__));
    }

    return $output->data;
}


/**
 * <?=$table_name?> 테이블에서 <?=$table_short_name?>를 리스트 형식으로 가져온다.
 * 
 * @param object $obj
 */
public static function get<?=$table_short_name?>List(object $obj): object
{
<?php
$priamary_key = '';
foreach($xml->children() as $column)
{
    if(in_array($column['name'], $condition_key))
    {
        if($priamary_key == '')
        {
            $priamary_key = $column['name'];
            break;
        }
    }
}
?>
    $obj->sort_index = $obj->sort_index ?? '<?=$priamary_key?>';
    $obj->order_type = $obj->order_type ?? 'desc';
    $obj->list_count = $obj->list_count ?? 20;
    $obj->page_count = $obj->page_count ?? 10;
    $obj->page = $obj->page ?? 1;

    $output = executeQueryArray('<?=$module_name?>.get<?=$table_short_name?>List', $obj);
    if(!$output->toBool())
    {
        throw new \Rhymix\Framework\Exceptions\DBError(sprintf("DB Error: %s in %s line %s", $output->getMessage(), __FILE__, __LINE__));
    }

    return $output;
}


/**
 * <?=$table_name?> 테이블에서 <?=$table_short_name?>를 업데이트한다.
 * 
 * @param object $obj
 */
public static function update<?=$table_short_name?>(object $obj): object
{
    $oDB = DB::getInstance();
    $oDB->begin();

    $output = executeQuery('<?=$module_name?>.update<?=$table_short_name?>', $obj);
    if(!$output->toBool())
    {
        $oDB->rollback();
        throw new \Rhymix\Framework\Exceptions\DBError(sprintf("DB Error: %s in %s line %s", $output->getMessage(), __FILE__, __LINE__));
    }
    $oDB->commit();

    return new BaseObject();
}

<?php
$param = '';
$comment = '';
$i = 0;
foreach($xml->children() as $column)
{
    if(in_array($column['name'], $condition_key))
    {
        if($i != 0)
        {
            $param .= ', ';
        }
        $param .= column_type_to_php($column['type']).' $'.$column['name'];
        $comment .= ' * @param '.column_type_to_php($column['type']).' $'.$column['name']."\r\n";
        $i++;
    }
}
?>
/**
 * <?=$table_name?> 테이블에서 <?=$table_short_name?>를 삭제한다.
 * 
<?=$comment?> */
public static function delete<?=$table_short_name?>(<?=$param?>): object
{
    $args = new \stdClass();
<?php
foreach($xml->children() as $column)
{
    if(in_array($column['name'], $condition_key))
    {
        echo '    $args->'.$column['name'].' = $'.$column['name'].';'."\r\n";
    }
}
?>

    $oDB = DB::getInstance();
    $oDB->begin();

    $output = executeQuery('<?=$module_name?>.delete<?=$table_short_name?>', $args);
    if(!$output->toBool())
    {
        $oDB->rollback();
        throw new \Rhymix\Framework\Exceptions\DBError(sprintf("DB Error: %s in %s line %s", $output->getMessage(), __FILE__, __LINE__));
    }
    $oDB->commit();

    return new BaseObject();
}
</code></pre>
<hr>
</div>
</section>
<br>
<footer>
    Made by <a href="//github.com/Waterticket" target="_blank">Waterticket</a>
</footer>

<script>
for (var preClick = document.getElementsByTagName("pre"), i = 0; i < preClick.length; i++)
{
    preClick[i].addEventListener(
    "dblclick",
    function () {
      var e = getSelection(),
        o = document.createRange();
      o.selectNodeContents(this),
        e.removeAllRanges(),
        e.addRange(o),
        document.execCommand("copy"),
        e.removeAllRanges(),
        (document.querySelector("#toastNotif").innerHTML =
          "<span>Copied to clipboard!</span>");
    },
    !1
  );
}

function downloadByZip()
{
    var codes = document.getElementsByClassName('codes');
    var zip = new JSZip();
    for(var i = 0; i < codes.length; i++)
    {
        var code = codes[i];
        var filename = code.getElementsByTagName('p')[0].innerHTML;
        var code_text = decodeEntities(code.getElementsByTagName('code')[0].innerHTML);
        console.log(code_text);
        zip.file(filename, code_text);
    }
    
    zip.generateAsync({type:"blob"}).then(function(content) {
        saveAs(content, "<?=$table_name?>_<?=date('YmdHis')?>.zip");
        document.querySelector("#toastNotif").innerHTML = "<span>Zip File Generated!</span>";
    });
}

var decodeEntities = (function() {
  // this prevents any overhead from creating the object each time
  var element = document.createElement('div');

  function decodeHTMLEntities (str) {
    if(str && typeof str === 'string') {
      // strip script/html tags
      str = str.replace(/<script[^>]*>([\S\s]*?)<\/script>/gmi, '');
      str = str.replace(/<\/?\w(?:[^"'>]|"[^"]*"|'[^']*')*>/gmi, '');
      element.innerHTML = str;
      str = element.textContent;
      element.textContent = '';
    }

    return str;
  }

  return decodeHTMLEntities;
})();
</script>
<script src="js/jszip.min.js"></script>
<script src="js/FileSaver.min.js"></script>
<div id='toastNotif' class='tNtf'></div>
</body>
</html>
