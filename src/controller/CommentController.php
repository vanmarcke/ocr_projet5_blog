<?php

namespace Projet5\controller;

/**
 * Managing the insertion of a comment 
 */
class CommentController extends SessionController
{
	/**
	 * insert a comment
	 *
	 * @param object $postModel
	 * @param object $commentModel 
	 * @param string $idPost contains the id of the post to comment 
	 *
	 * @return void
	 */
	public function insertComment(object $postModel, object $commentModel, string $idPost)
	{
		// The form is submitted, control
		$contents = (isset($_POST['contents'])) ? $_POST['contents'] : "";
		$errors = [];

		$this->checkComment($contents, $errors);

		// insert the comment and redirect
		if (empty($errors)) {
			$commentModel->insertComment([
				'contents' => $contents,
				'id_blog_post' => $idPost,
				'id_user' => $_SESSION['IdConnectedUser']
			]);
			// redirect on post
			$_SESSION['success'] = 'Votre commentaire à été envoyé, il est en attente de validation par un administrateur';
			header('location:Article-' . $idPost . '-Page1');
			exit;
		} else {
			// redirect on post with error
			$_SESSION['error'] = $errors['contents'];
			header('location:Article-' . $idPost . '-Page1');
			exit;
		}
	}
}
