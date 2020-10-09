<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');

function listPosts()
{
    $postManager = new tpmvc\Model\PostManager();
    $posts = $postManager->getPosts();

    require('view/frontend/listPostsView.php');
}

function post()
{
    $postManager = new tpmvc\Model\PostManager();
    $commentManager = new tpmvc\Model\CommentManager();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('view/frontend/postView.php');
}

function addComment($postId, $author, $comment)
{
    $commentManager = new tpmvc\Model\CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}

function viewComment()
{
    $commentManager = new tpmvc\model\CommentManager();
    $comment = $commentManager->getComment($_GET['id']);
  
    require('view/frontend/editView.php');
}
  
  
function editComment($id, $comment)
{
    $commentManager = new tpmvc\model\CommentManager();
  
    $newComment = $commentManager->updateComment($id, $comment);
  
    if ($newComment === false) {
  
        throw new Exception('Impossible de modifier le commentaire !');
    }
    else {
        echo 'commentaire : ' . $_POST['comment'];
        header('Location: index.php?action=viewComment&id=' . $id);
    }
}


