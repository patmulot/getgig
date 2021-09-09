<?php

namespace getgigwp;

use WP_REST_Request;
use WP_User;

class Api
{
    /**
     * @var string
     */
    protected $baseURI;

    public function __construct()
    {
        add_action(
            'rest_api_init',
            [$this, 'initialize']
        );
    }

    public function initialize()
    {
        // -------------- CUSTOM USER ENDPOINTS -------------- //
        $this->baseURI = dirname($_SERVER['SCRIPT_NAME']);
        register_rest_route(
            'getgigwp/v1/',
            '/register',
            [
                'methods' => 'post',
                'callback' => [$this, 'register']
            ]
        );
        $this->baseURI = dirname($_SERVER['SCRIPT_NAME']);
        register_rest_route(
            'getgigwp/v1/',
            '/user-update',
            [
                'methods' => 'post',
                'callback' => [$this, 'updateUser']
            ]
        );
        // -------------- CUSTOM NENENCEMENT ENDPOINTS -------------- //
        register_rest_route(
            'getgigwp/v1/',
            '/announcement-save',
            [
                'methods' => 'post',
                'callback' => [$this, 'announcementSave']
            ]
        );
        
        register_rest_route(
            'getgigwp/v1/',
            '/upload-image',
            [
                'methods' => 'post',
                'callback' => [$this, 'uploadImage']
            ]
        );
        register_rest_route(
            'getgigwp/v1/',
            '/announcement-delete',
            [
                'methods' => 'delete',
                'callback' => [$this, 'deleteAnnouncement']
            ]
        );

        // -------------- CUSTOM MESSAGES ENDPOINTS -------------- //
        //! tests : -------------------------------------
        register_rest_route(
            'getgigwp/v1/',
            '/messages',
            [
                'methods' => 'get',
                'callback' => [$this, 'getAllMessages']
            ]
        );
        //! -------------------------------------------
        //  example url : http://localhost/neo/getgig/projet-get-gig/public/index.php/wp-json/getgigwp/v1/messages/sender/2
        register_rest_route(
            'getgigwp/v1/',
            '/messages/sender/(?P<id>[\d]+)',
            [
                'methods' => 'get',
                'callback' => [$this, 'getAllRecipientIdFromSender']
            ]
        );
        register_rest_route(
            'getgigwp/v1/',
            '/messages/contacts/sender/(?P<senderid>[\d]+)/recipient/(?P<recipientid>[\d]+)',
            [
                'methods' => 'get',
                'callback' => [$this, 'getAllContactsFromSenderId']
            ]
        );
        //  example url : http://localhost/neo/getgig/projet-get-gig/public/index.php/wp-json/getgigwp/v1/messages/sender/2
        register_rest_route(
            'getgigwp/v1/',
            '/messages/sender/(?P<senderid>[\d]+)/recipient/(?P<recipientid>[\d]+)',
            [
                'methods' => 'get',
                'callback' => [$this, 'getAllMessagesFromSenderAndRecipient']
            ]
        );
        register_rest_route(
            'getgigwp/v1/',
            '/message-save',
            [
                'methods' => 'post',
                'callback' => [$this, 'messageSave']
            ]
        );
       

    }
    // -------------- CUSTOM USER GETTERS & SETTERS -------------- //
    public function register(WP_REST_Request $request)
    {
        $userName = $request->get_param('username');
        $userPassword = $request->get_param('password');
        $userEmail = $request->get_param('email');
        // meta fieds :
        $role = $request->get_param('role');
        $location = $request->get_param('location');

        $userCreateResult = wp_create_user(
            $userName,
            $userPassword,
            $userEmail,
        );

        $userData = [
            'ID' => $userCreateResult,
            'user_nicename' => $role,
        ];
        wp_update_user($userData);
        // inserting or updating new meta data "location" from user form from front :
        update_user_meta($userCreateResult, 'userlocation', $location);
        update_user_meta($userCreateResult, '_userlocation', "field_61272e8e31ae8");

        if (is_int($userCreateResult)) {
            $user = new WP_User($userCreateResult);
            $user->remove_role('subscriber');
            $user->add_role($role);

            //! ======================================================================
            //! A chaque nouvel utilisateur, je lui fait créer un post pour pouvoir le retrouver dans la route api /user/id
            $newUserPostMessage = "new user created, id = " . $userCreateResult;
            $newUserPost = [
                'post_content' => $newUserPostMessage,
                'post_title' => $userName,
                'post_author' => $userCreateResult,
                'post_status' => 'publish',
                'post_type' => 'post',
            ];
            wp_insert_post($newUserPost);
            //! ======================================================================

            return [
                'success' => true,
                'userId' => $userCreateResult,
                'username' => $userName,
                'email' => $userEmail,
                'role' => $role,
                'userlocation' => $location,
            ];
        } else {
            return [
                'success' => false,
                'error' => $userCreateResult
            ];
        }
    }
    public function updateUser(WP_REST_Request $request)
    {
        $userId = $request->get_param('userid');
        // $userPassword = $request->get_param('password');
        $userName = $request->get_param('username');
        $userEmail = $request->get_param('email');
        $userUrl = $request->get_param('url');
        $userDescription = $request->get_param('description');
        // meta fieds :
        $location = $request->get_param('location');
        $userData = [
            'ID' => $userId,
            'display_name' => $userName,
            // 'user_pass' => $userPassword,
            'user_email' => $userEmail,
            'user_url' => $userUrl,
            'description' => $userDescription,
        ];
        wp_update_user($userData);
        update_user_meta($userId, 'userlocation', $location);
        update_user_meta($userId, '_userlocation', "field_61272e8e31ae8");
        // if ($userToUpdate) {
        return [
            'success' => true,
            'userId' => $userId,
            'username' => $userName,
            'email' => $userEmail,
            'user_url' => $userUrl,
            'description' => $userDescription,
            'userlocation' => $location,
        ];
        // } else {
        //     return [
        //         'success'=> false,
        //         'error' => $userCreateResult
        //     ];
        // }
    }
    public function removeUser(WP_REST_Request $request)
    {
        // $userId = $request->get_param('userToRemoveId');
        wp_delete_user(16);
    }

    // -------------- CUSTOM NENENCEMENT GETTERS & SETTERS -------------- //

    public function announcementSave(WP_REST_Request $request)
    { // #1 on récupère toutes les données reçues par l'API sous forme d'un tableau $request qui a pour clés les noms des données envoyées
        $title = $request->get_param('announcementTitle');
        $role = $request->get_param('announcementRole');
        $content =  $request->get_param('announcementContent');
        $location = $request->get_param('announcementLocation');


        $imageId = $request->get_param('announcementImageId');
        $startDate =  $request->get_param('announcementStartDate');
        $endDate =  $request->get_param('announcementEndDate');

        // récupération de l'utilisateur ayant envoyé la requête
        $user = wp_get_current_user();

        // contrôle des roles : est ce que la valeur "contributor" existe dans le tableau $user->roles
        // if (in_array( 'contributor', (array) $user->roles ) ) {


        // DOC WP create post https://developer.wordpress.org/reference/functions/wp_insert_post/
        $announcementCreateResult = wp_insert_post(
            [
                'post_title' => $title,
                'post_content' => $content,
                //'tax_input' => ['Type' => $role],
                'meta_input' => [
                    'location'   => $location,  //le contenu des Custom Fields
                    'date_start' => $startDate,
                    'date_end'   => $endDate,
                ],
                'post_status' => 'publish',


                // WARNING WP create post : ne pas oublier de préciser le post type
                'post_type' => 'announcements',
            ]
        );




            
        if (is_int($announcementCreateResult)) {
            if ($imageId) {
                set_post_thumbnail(
                    $announcementCreateResult,
                    $imageId
                );

                wp_set_object_terms(
                    $announcementCreateResult,
                    [$role],
                    'Type'
                );
            }
        }



        return [
            'title'      => $title,
            'content'    => $content,
            'location'   => $location,
            'date_start' => $startDate,
            'date_end'   => $endDate,
            'post_id'    => $announcementCreateResult,
        ];
    }


    public function uploadImage(WP_REST_Request $request)
    {

        // correspond au nom de la variable utilisée pour envoyer l'image
        $imageFileIndex = 'image';

        // récupération des informations concernant l'image uploadée
        $imageData = $_FILES[$imageFileIndex];

        // récupération du chemin fichier dans lequel est stockée l'image qui vient d'être uploadée
        $imageSource = $imageData['tmp_name'];

        // récupération es informations du dossier dans lequel wp stocke les fichiers uploadés
        $destination = wp_upload_dir();

        // dossier worpdress dans lequel nous allons stocker l'image
        $imageDestinationFolder = $destination['path'];

        // DOC nettoyage d'un nom de fichier avec wp https://developer.wordpress.org/reference/functions/sanitize_file_name/
        $imageName =  sanitize_file_name(
            md5(uniqid()) . '-' . // génération d'une partie aléatoire pour ne pas écraser de fichier existant
            $imageData['name']);
        $imageDestination = $imageDestinationFolder . '/' . $imageName;

        // on déplace le fichier uploadé dans le dossier de stokage de wp
        $success = move_uploaded_file($imageSource, $imageDestination);

        // si le déplacement du fichier à bien fonctionné
        if($success) {
            // récupération des informations dont wordpress a besoin pour identifier le type de fichier uploadé
            $imageType =  wp_check_filetype( $imageDestination, null);

            // préparation des informations nécessaires pour créer le media
            $attachment = array(
                'post_mime_type' => $imageType['type'],
                'post_title' => $imageName,
                'post_content' => '',
                'post_status' => 'inherit'
            );

            // on enregistre l'image dans wordpress
            $attachmentId = wp_insert_attachment( $attachment, $imageDestination );

            if(is_int($attachmentId)) {
                // youpi merci wordpress...
                require_once( ABSPATH . 'wp-admin/includes/image.php' );

                // DOC on génère les metadatas pour le média https://developer.wordpress.org/reference/functions/wp_generate_attachment_metadata/
                $metadata = wp_generate_attachment_metadata( $attachmentId, $imageDestination );

                // on met à jour les metadata du media
                wp_update_attachment_metadata( $attachmentId, $metadata );

                return [
                    'status' => 'success',
                    'image' => [
                        'url' => $destination['url'] . '/' . $imageName,
                        'id' => $attachmentId
                    ]
                ];
            }
            else {
                return [
                    'status' => 'failed'
                ];
            }
        }

        return [
            'status' => 'failed'
        ];
    }
    // -------------- USER GETTERS & SETTERS -------------- //
    // public function getAllMessages()
    // {
    //     global $wpdb;
    //     $query = "SELECT * FROM `messages`";
    //     $list = $wpdb->get_results($query);
    //     return $list;
    // }
    public function getAllRecipientIdFromSender(WP_REST_Request $request)
    {
        $senderId = $request->get_param('id');
        // example url : http://localhost/neo/getgig/projet-get-gig/public/index.php/wp-json/getgigwp/v1/messages/sender/2
        global $wpdb;
        $query = "SELECT `recipient_id` FROM `messages` WHERE `sender_id` = " . $senderId;
        $list = $wpdb->get_results($query);
        return $list;
    }
    public function getAllContactsFromSenderId(WP_REST_Request $request)
    {
        $senderId = $request->get_param('senderid');
        // $recipientId = $request->get_param('recipientid');
        // example url : http://localhost/neo/getgig/projet-get-gig/public/index.php/wp-json/getgigwp/v1/messages/sender/2
        global $wpdb;
        $query = "SELECT * FROM `messages` WHERE `sender_id` = " . $senderId . " OR `recipient_id` = " . $senderId;
        $list = $wpdb->get_results($query);
        return $list;
    }
    public function getAllMessagesFromSenderAndRecipient(WP_REST_Request $request)
    {
        $senderId = $request->get_param('senderid');
        $recipientId = $request->get_param('recipientid');
        // example url : http://localhost/neo/getgig/projet-get-gig/public/index.php/wp-json/getgigwp/v1/messages/sender/2
        global $wpdb;
        $query = "
        SELECT * 
        FROM `messages` 
        WHERE `sender_id` = " . $senderId . " 
        AND `recipient_id` = " . $recipientId . "
        OR `sender_id` = " . $recipientId . "
        AND `recipient_id` = " . $senderId
        ;
        $list = $wpdb->get_results($query);
        return $list;
    }
    public function messageSave(WP_REST_Request $request)
    {
        $senderId = $request->get_param('senderid');
        $recipientId = $request->get_param('recipientid');
        $senderMessage = $request->get_param('message');
        global $wpdb;
        $tableName = "messages";
        $wpdb->insert(
            $tableName,
            array(
                "sender_id" => $senderId,
                "recipient_id" => $recipientId,
                "content" => $senderMessage,
                "created_at" => date('Y-m-d H:i:s')
            )
        );
        return [
            'success' => true,
            'sender_id' => $senderId,
            'recipient_id' => $recipientId,
            'content' => $senderMessage,
        ];
    }
}
