<?php

$url = "https://mail.finbroc.ru/owa/#path=/mail";

$user = 'bakulin_av@finansda.ru\grantey@gmail.com';
$password = 'Vjcrdfabylf951';
$server = '{smtp.office365.com:465/imap/tls}';
//$server = '{outlook.office365.com:993/imap/ssl}';
//$server = '{outlook.office365.com:993/imap/ssl/authuser=bakulin_av@finansda.ru/user=grantey@gmail.com}';
//$server = '{outlook.office365.com:993/imap/ssl}INBOX';

/* connect to gmail */
/*
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'grantey@gmail.com';
$password = 'afyufhbjh';
*/
/* try to connect */
//$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

?>
<style>
div.toggler { border:1px solid #ccc; background:url(gmail2.jpg) 10px 12px #eee no-repeat; cursor:pointer; padding:10px 32px; }
div.toggler .subject { font-weight:bold; }
div.read { color:#666; }
div.toggler .from, div.toggler .date { font-style:italic; font-size:11px; }
div.body { padding:10px 20px; }
</style>

<script>
    window.addEvent('domready',function() {
	var togglers = $$('div.toggler');
	if(togglers.length) var gmail = new Fx.Accordion(togglers,$$('div.body'));
	togglers.addEvent('click',function() { this.addClass('read').removeClass('unread'); });
	togglers[0].fireEvent('click'); //first one starts out read
});
</script>

<?php
//$inbox = imap_open("{imap.yandex.ru/imap:143}INBOX", "grtony@yandex.ru", "afyufhbjh");
//$inbox = imap_open ("{outlook.office365.com:325/imap/ssl/authuser=bakulin_av@finansda.ru/user=grantey@gmail.com}", "bakulin_av@finansda.ru", "Vjcrdfabylf951");
$inbox = imap_open($server, $user, $password, OP_READONLY, 1, array('DISABLE_AUTHENTICATOR' => 'PLAIN'));

$mails = imap_search($inbox,'NEW',SE_FREE, "UTF-8");
print_r($inbox);

/* if emails are returned, cycle through each... */
if($mails){
    // открываем каждое новое письмо
    foreach($mails as $oneMail){
        // получаем заголовок
        $header = imap_header($inbox, $oneMail);
        print_r($header);
        // достаем ящик отправителя письма
        $mailSender = $header->sender[0]->mailbox . "@" . $header->sender[0]->host;
        //print_r($header);
        
        $subject = $header->subject;        
        $headers = imap_fetchbody($inbox, $oneMail, 0); // получаем заголовки        
        $message = imap_fetchbody($inbox, $oneMail, 1); // получаем текст письма
        
        echo imap_utf8($subject).'<br>';
        echo imap_utf8($mailSender).'<br>';
        
        if (strpos($headers, 'Content-Type: text/plain') !== false) {
            echo imap_utf8($message).'<br>';
        }
        else {
            echo imap_base64($message).'<br>';
        }        
        echo '------------------------<br>';
    }
}

/* close the connection */
imap_close($inbox);

//$mbox = imap_open ("{outlook.office365.com:325/imap/ssl/authuser=bakulin_av@finansda.ru/user=grantey@gmail.com}", "bakulin_av@finansda.ru", "Vjcrdfabylf951");
//$mbox = imap_open("{imap-mail.outlook.com:993/ssl}", $user, $password, OP_HALFOPEN);
//$mbox = imap_open("{imap.gmail.com:993/imap/ssl/novalidate-cert}", "grantey", "afyufhbjh", NULL, 1, array('DISABLE_AUTHENTICATOR' => 'GSSAPI'));
// Находим и сохраняем нужный фрагмент
//preg_match( '/<ul><li>(.*?)<\/li><\/ul>/is' , $text , $links );

// Выводим результат на экран
echo $mbox;