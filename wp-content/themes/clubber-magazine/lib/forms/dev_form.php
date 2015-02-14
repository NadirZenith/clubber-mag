<?php

/*return 'hola';*/
if($_SERVER['REQUEST_METHOD'] == 'POST'){
     $var = 'post'; 
}else{
     $var = 'get else'; 
      
}
      

/* create form */
$form = new Zebra_Form( pathinfo( __FILE__ )[ 'filename' ] );

/* add components */
//$form->add( 'label', 'label_name', 'name', 'Your name:' ); //<label for="name" id="label_name">Your name:</label>
//$obj = $form->add( 'text', 'name', '' ); //<input type="text" name="name" id="name" value="" class="control text">


$form->add( 'label', 'label_name', 'artist_name', 'Artist Name:' ); //<label for="name" id="label_name">Your name:</label>
$obj = $form->add( 'text', 'artist_name', $var ); //<input type="text" name="name" id="name" value="" class="control text">

$obj->set_rule( array(
      // error messages will be sent to a variable called "error", usable in custom templates
      'required' => array( 'error', 'Name is required!' ),
          //'email' => array( 'error', 'Email address seems to be invalid!' ),
) );

// the label for the "file" element
$form->add( 'label', 'label_file', 'file', 'Photo' );

// add the "file" element
$obj = $form->add( 'file', 'file' );
/*
 */

// set rules
$obj->set_rule( array(
      // error messages will be sent to a variable called "error", usable in custom templates
      //'required' => array( 'error', 'An image is required!' ),
      'upload' => array( 'tmp', true, 'error', 'Could not upload file!dir' ),
      // notice how we use the "image" rule instead of the "filetype" rule (used in previous example);
      // the "image" rule does a thorough checking aimed specially for images
      '//image' => array( 'error', 'File must be a jpg, png or gif image!' ),
          //'filesize' => array( 1024000000, 'error', 'File size must not exceed 100Kb!' ),
) );

// attach a note
/* $form->add( 'note', 'note_file', 'file', 'File must have the .jpg, .jpeg, png or .gif extension, and no more than 100Kb!' ); */



//add submit button
$form->add( 'submit', 'btn_submit', 'Submit' ); //<input type="submit" name="btn_submit" id="btn_submit" value="Submit" class="submit">


/* handle form */
if ( $form->validate() ) {
      //form is valid
      //create post



      wp_safe_redirect( get_home_url() );
      f( $form );
      exit();
} else {
      $output = $form->render( '', true );

      return $output;
}


/*
  // set rules
  $obj->set_rule( array(
  // error messages will be sent to a variable called "error", usable in custom templates
  'required' => array( 'error', 'Name is required!' )
  ) );

  // "email"
  $form->add( 'label', 'label_email', 'email', 'Your email address:' );
  $obj = $form->add( 'text', 'email', '', array( 'data-prefix' => 'img:public/images/letter.png' ) );
  $obj->set_rule( array(
  'required' => array( 'error', 'Email is required!' ),
  'email' => array( 'error', 'Email address seems to be invalid!' ),
  ) );
  $form->add( 'note', 'note_email', 'email', 'Your email address will not be published.' );

  // "website"
  $form->add( 'label', 'label_website', 'website', 'Your website:' );
  $obj = $form->add( 'text', 'website', '', array( 'data-prefix' => 'http://' ) );
  $obj->set_rule( array(
  'url' => array( true, 'error', 'Invalid URL specified!' ),
  ) );
  $form->add( 'note', 'note_website', 'website', 'Enter the URL of your website, if you have one.' );

  // "subject"
  $form->add( 'label', 'label_subject', 'subject', 'Subject' );
  $obj = $form->add( 'text', 'subject', '', array( 'data-prefix' => 'img:public/images/comment.png' ) );
  $obj->set_rule( array(
  'required' => array( 'error', 'Subject is required!' )
  ) );

  // "message"
  $form->add( 'label', 'label_message', 'message', 'Message:' );
  $obj = $form->add( 'textarea', 'message' );
  $obj->set_rule( array(
  'required' => array( 'error', 'Message is required!' ),
  'length' => array( 0, 140, 'error', 'Maximum length is 140 characters!', true ),
  ) );
 */

return;

$form = new NZ_WP_Form( 'event' );

$form->addField( 'post_title', 'type', 'label', 'message' );
