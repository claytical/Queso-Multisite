#Laravel SimpleMessage#

SimpleMessage is a Laravel extension bundle that allows you to easily send messages to your views, centralizing your application's message system and keeping you nice and [DRY][dry].

[dry]: http://en.wikipedia.org/wiki/Don't_repeat_yourself "Don't Repeat Yourself"

If you're familiar with [Laravel's validation error messages][validation], you'll find SimpleMessage follows similar conventions.

[validation]: http://laravel.com/docs/validation#retrieving-error-messages

    // redirect to a route with a message
    return Redirect::to('item_list')->with_message('Your item was added.', 'success');

    // retrieve messages
    foreach ($messages->all() as $message)
    {
      echo $message;
    }

##Updates##
* 2013-03-01 Added `Redirect::with_lang_message()` convenience method, which allows sending localized messages to views.

###How to Update###
Update SimpleMessage [using artisan]:
  
[using artisan]: http://laravel.com/docs/bundles#upgrading-bundles

    php artisan bundle:upgrade simplemessage

That should do it. Or, if you're [using github][github], simply download the bundle code again and replace the **simplemessage** directory. 

##Installation##

You can install SimpleMessage through [artisan][art-install]:

[art-install]: http://laravel.com/docs/bundles#installing-bundles

    php artisan bundle:install simplemessage

Or through github: [http://github.com/ashour/laravel-simplemessage][github]

[github]: http://github.com/ashour/laravel-simplemessage

If you get it through github, make sure to copy the **laravel-simplemessage** directory into your bundles directory, and to rename it **simplemessage**.

Once you've installed the bundle, register it by adding an entry in your **application/bundles.php** file:

    return array('some_other_bundle' => array(...), 'yet_another', 'simplemessage');

Add the bundle to your **application/start.php** file under `Autoloader::directories`:

    Autoloader::directories(array(
      path('app').'models',
      path('app').'libraries',
      Bundle::path('simplemessage').'src',
    ));

Finally, set your `Register` and `View` aliases to use the SimpleMessage classes in **application/config/application.php**. (Don't worry, SimpleMessage simply extends the Laravel core classes):

    return array(
      // ... other configs

      'aliases' => array(
        // ... other aliases
        //'Redirect'    => 'Laravel\\Redirect',
        'Redirect'    => 'SimpleMessage\\Redirect',
        // ...
        //'View'        => 'Laravel\\View',
        'View'        => 'SimpleMessage\\View',
      ),
    );

That's it. You're all installed and ready to use SimpleMessage.

##Redirecting with Messages##

When you want to send a message to a view via redirect, say to send a success message that notifies the user that an item was added, just use the simple `with_message()` method.

###Redirect with a message###

    return Redirect::to('item_list')
      ->with_message('Hey, you should know about this.');

###Redirect with a message and type###

    return Redirect::to('item_list')
      ->with_message('Your item was added.', 'success');

###Redirect with multiple messages###

    return Redirect::to('item_list')
      ->with_message('Your item was added.', 'success')
      ->with_message('Another thing you need to know.', 'info');
      
##Localized Messages##
If your application is displayed in multiple languages, SimpleMessage provides a `with_lang_message()` method for redirecting with localized messages. Provide the key of the language line you wish to display, just as you would with [Laravel's `Lang::line()` method or `__()` function][lang_get].
    
[lang_get]: http://laravel.com/docs/localization#get

###Redirect with a localized message###

    return Redirect::to('item_list')
      ->with_lang_message('items.item_added');
      
###Redirect with a localized message and type###

    return Redirect::to('item_list')
      ->with_lang_message('items.item_added', 'success');


##Retrieving Messages##

SimpleMessage makes a `$messages` object available to all your views. It works similarly to Laravel's validation `$errors` object.

###Retrieve all messages###

    foreach ($messages->all() as $message)
    {
      echo $message;
    }

###Retrieve all messages of a given type###
  
    foreach ($messages->get('success') as $message)
    {
      echo $message;
    }
  
###Retrieve first message of all messages###

    echo $messages->first();

###Retrieve first message of a given type###

    echo $messages->first('success');

###Check if messages of a given type exist###

    if ($messages->has('success'))
    {
      echo $messages->first('success');
    }

##Formatting##

If you're using something like Twitter Bootstrap, or your own CSS styling, you'll appreciate SimpleMessage's message formatting. Just like Laravel's validation errors, SimpleMessage's retrieval methods take an optional format parameter, which allows you to easily format your messages using `:message` and `:type` placeholders.

###Retrieve all messages with formatting###

    foreach ($messages->all('<p class=":type">:message</p>') as $message)
    {
      echo $message;
    }

###Retrieve all messages of a given type with formatting###

    foreach ($messages->get('success', '<p class=":type">:message</p>') as $message)
    {
      echo $message;
    }

###Retrieve first message of a given type with formatting###

    echo $messages->first('success', '<p class=":type">:message</p>');

###Retrieve first message of all messages with formatting###

    echo $messages->first(null, '<p class=":type">:message</p>');

##Message Attributes##

For maximum flexibility, you can access the text and type of a message directly through message attributes.

###Access message attributes###

    foreach ($messages->all() as $message)
    {
      echo 'Message text: '.$message->text.'<br>';
      echo 'Message type: '.$message->type.;
    }

##View Partial##

For convenience, SimpleMessage provides a partial view that outputs all messages using the [Twitter Bootstrap alert class convention][bootstrap]. Just include it in a [Blade][blade] view:

[bootstrap]: http://twitter.github.com/bootstrap/components.html#alerts
[blade]: http://laravel.com/docs/views/templating#blade-template-engine

    @include('simplemessage::out')

##Unit Tests##

I've tried to test the SimpleMessage bundle as thoroughly as possible. You can run the SimpleMessage tests through Laravel's [artisan][artisan] command-line utility:

[artisan]: http://laravel.com/docs/artisan/commands#unit-tests

    php artisan test simplemessage