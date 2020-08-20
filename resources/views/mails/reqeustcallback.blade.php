<?php
/**
 * User: Bhavin
 * Date: 6/26/2020
 * Time: 12:40 AM
 */

?>
Hello <i>{{ $reqeustCallback->receiver }}</i>,
<p>This is a reqeust callback email has been submitted by the user.</p>

<p><u>User details:</u></p>

<div>
    <p><b>Name:</b>&nbsp;{{ $reqeustCallback->requestname }}</p>
    <p><b>Telephone:</b> {{ $reqeustCallback->requesttelephone }}</p>
    <p><b>Email:</b> {{ $reqeustCallback->requestemail }}</p>
    <p><b>Inquiry:</b> {{ $reqeustCallback->requestcomments }}</p>
</div>

Thank You,
<br/>
<i>{{ $reqeustCallback->sender }}</i>
