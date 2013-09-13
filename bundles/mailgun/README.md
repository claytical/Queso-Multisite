# Laravel Mailgun

A Laravel Mailgun bundle, installable via the Artisan

   php artisan bundle:install mailgun

Add it to `application/bundles.php`

    return array(
      ...
      'mailgun' => array(
        'auto' => true
      ),
      ...
    );

You'll have to edit the `config/mailgun.php` to change `domain` for yours and `api_key` from the your account information on [Mailgun](http://www.mailgun.net).

## Usage example

    Mailgun::message(function($mg) {
      $mg->from('your@email.com')
         ->to('other@email.com')
         ->text('shazam');

      return $mg;
    })->deliver();

Base on a [tweet](http://twitter.com/laravelphp/status/235951044348223488) from Laravel. I've decided to make something similar to it for Mailgun API.

## Introduction

Inside the previous example, you can add any variables to the Mailgun instance by using setter or functions:

    // by function
    $mg->from('your@email.com');
    
    // by setter
    $mg->from = 'your@email.com';

Default static functions has been included too: message, unsubscribe, unsubscribes, complaint, complaints, bounce, bounces, stats, log, route, routes, mailbox, mailboxes and compaigns. But you can call something else if a new function in the Mailgun API becomes available by using the magic __callStatic function:

    Mailgun::new_function([$method], Closure)->deliver();

`$method` is optional and by default set to 'GET'. Multiple functions to change that is available: `post`, `get`, `put`, `delete`.

`path` function will add more data to url.

**Note:** `o:tag` can be use by `$mg->param('o:tag', $value)`

## [Sending messages](http://documentation.mailgun.net/api-sending.html)

    Mailgun::message(\Closure $setter = null)

### Parameters

* `from`, Email address for `From` header
* `to`, Email addresss of the recipient(s). Example: `Bob <bob@host.com>`. You can use commas to seperate multiple recipients.
* `cc`, Same as `To` but for `Cc`
* `bcc`, Same as `To` but for `Bcc`
* `subject`, Message subject
* `text`, Body of the message. (text version)
* `html`, Body of the message. (HTML version)
* `attachment`, File attachment. You can post multiple values. **Important:** You must use `multipart/form-data` encoding when sending attachments.
* `inline`, Attachment with `inline` dispositions. Can be used to send inline images. You can post multiple `inline` values.
* `o:tag`, Tag string.
* `o:campaign`, Id of the campaign the message belongs to.
* `o:dkim`, Enables/disables DKIM signatures on per-messages basis. Pass `yes` or `no`
* `o:deliverytime`, Desired time of delivery. See [Date Format](http://documentation.mailgun.net/api-intro.html#date-format).
* `o:testmode`, Enables sending in test mode. Pass `yes` if needed. See [Sending in Test Mode](http://documentation.mailgun.net/user_manual.html#manual-testmode).
* `o:tracking`, Toggles tracking on a per-message basis, see [Tracking Messages](http://documentation.mailgun.net/user_manual.html#tracking-messages) for details. Pass `yes` or `no`.
* `o:tracking-clicks`, Toggles clicks tracking on a per-message basis. Has higher priority than domain-level setting. Pass `yes`, `no` or `htmlonly`.
* `o:tracking-opens`, Toggles opens tracking on a per-message basis. Has higher priority than domain-level setting. Pass `yes` or `no`
* `h:X-My-Header`, `h:` prefix followed by an arbitrary value allows to append a custom MIME header to the message (X-My-Header in this case)).
* `v:my-var`, `v:` prefix followed by an arbitrary name allows to attach a custom JSON data to the message. See [Attaching Data to Messages](http://documentation.mailgun.net/user_manual.html#manual-customdata) for more information.

### Example

    Mailgun::message(function($mg) {
      $mg->from('your@email.com')
         ->to('other@email.com')
         ->subject('test')
         ->text('some text here')
         ->attachment('file.png')
         ->attachment('file2.png')
         ->param('o:tag', 'august');

      return $mg;
    })->deliver();

### Response

    {
      "message": "Queued. Thank your.",
      "id": "<20111115080851.17787.43714@samples.mailgun.org>"
    }

## [Unsubscribes](http://documentation.mailgun.net/api-unsubscribes.html)

    Mailgun::unsubscribe(\Closure $setter = null) // POST

### Parameters

* `address`, Valid email address.
* `tag`, Tag to unsubscribe from, use `*` to unsubscribe address from domain.

### Example

    Mailgun::unsubscribe(function($mg) {
      $mg->address('your@email.com')
         ->tag('*');

      return $mg;
    })->deliver();


***More documentation to follow***

But basicly, you can go to the [documentation](http://documentation.mailgun.net/api_reference.html) from Mailgun and see what parameters for each call.