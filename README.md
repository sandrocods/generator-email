## TempMail CLI
###### Library for easy use of generator.email

### Instalation
Include this code
```php
<?php
include 'lib/Class_temp.php';
```

------------


### Features
1. Generator Email 
2. ReadSingleMessage
3. ReadSecret
4. ReadMessagebySecret
5. MarkAllRead
6. DeleteAll
7. ReadAllMessage

------------

### How To Use
1. Generator Email
```php
<?php
include 'lib/Class_Curl.php';
$Get = GenEmail::GetEmail(); // if you want a custom name, add a parameter in the function . Ex : GenEmail::GetEmail('sandrocods')
print_r($Get);
```
**Result**
> 
Array
(
    [email] => 3estherblom83m@traclecfa.gq
    [name] => 3estherblom83m
    [domain] => traclecfa.gq
)

2. ReadSingleMessage
```php
<?php
include 'lib/Class_Curl.php';
$Get = GenEmail::GetEmail();
$Read = GenEmail::ReadSingleMessage($Get['name'],$Get['domain']);
print_r($Read);
```
**Result**
> 
Array
(
    [Sender] => krxxxxxxxx@gmail.com
    [Time] => 2020-10-31 15:13:14
    [Subject] => A
    [Message] => <div dir="ltr">A<div><br /></div></div></div>
)
3. ReadSecret
**Read secret is used to read 1: 1 messages**
```php
<?php
include 'lib/Class_Curl.php';
$Get = GenEmail::GetEmail();
$Read = GenEmail::ReadSecret($Get['name'],$Get['domain']);
print_r($Read);
```
**Result**
> 	Array
		(
   	 [Total Message] => 2
    	[Secret] => Array
        (
            [0] => 386efc90cd2b3dfa330737a9006b025c
            [1] => 15d628f2aa44ad0e213f5036a8c944a2
        ))

4. ReadMessagebySecret
```php
<?php
include 'lib/Class_Curl.php';
$Get = GenEmail::GetEmail();
$Read = GenEmail::ReadSecret($Get['name'],$Get['domain']);
$Read_one = GenEmail::ReadMessagebySecret($Get['name'],$Get['domain'],$Read['Secret'][0]);
print_r($Read_one);
```
**Result**
> Array
(
    [Sender] => krisandromartinus@gmail.com
    [Time] => 2020-10-31 15:17:27
    [Subject] => Re: A
    [Message] => <div dir="ltr">a</div><br /><div class="gmail_quote"><div dir="ltr" class="gmail_attr">Pada tanggal Sab, 31 Okt 2020 pukul 22.12 Sandro putraa &lt;<a href="mailto:krixxxx@gmail.com" rel="nofollow" target="_blank">krixxxx@gmail.com</a>&gt; menulis:<br /></div><blockquote class="gmail_quote" style="margin: 0px 0px 0px 0.8ex; border-left: 1px solid rgb(204,204,204); padding-left: 1ex"><div dir="ltr">A<div><br /></div></div>
</blockquote></div></div>
)

5. MarkAllRead
**To make all messages visible**
```php
<?php
include 'lib/Class_Curl.php';
$Get = GenEmail::GetEmail();
$Read = GenEmail::MarkAllRead($Get['email'],$Get['domain']);
print_r($Read);
```
**Result**
> Array
(
    [Status] => Messages marked successfully
)

6. DeleteAll
**To Delete all messages **
```php
<?php
include 'lib/Class_Curl.php';
$Get = GenEmail::GetEmail();
$Read = GenEmail::DeleteAll($Get['email'],$Get['domain']);
print_r($Read);
```
**Result**
> Array
(
    [Status] => Messages deleted successfully
)
7. ReadAllMessage
**To Read all messages in inbox **
```php
<?php
include 'lib/Class_Curl.php';
$Get = GenEmail::GetEmail();
$Get_secret = GenEmail::ReadAllMessage($Get['name'] , $Get['domain']);
print_r($Get_secret);
```
**Result**
> 
		Array
		(
    	[0] => Array
        (
            [Sender] => krixxx@gmail.com
            [Time] => 2020-10-31 15:17:27
            [Subject] => Re: A
            [Message] => </div><blockquote class="gmail_quote" style="margin: 0px 0px 0px 0.8ex; border-left: 1px solid rgb(204,204,204); padding-left: 1ex"><div>
		)
    	[1] => Array
        	(
            [Sender] => krixxxx@gmail.com
            [Time] => 2020-10-31 15:17:27
            [Subject] => Re: A
            [Message] => <div dir="ltr">A<div><br /></div></div></div>
        )
  )
