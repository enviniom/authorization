<?php
namespace TestApp\Policy;

use TestApp\Model\Entity\Article;

class ArticlePolicy
{

    /**
     * Create articles if you're an admin or author
     *
     * @param array $user
     * @return bool
     */
    public function canAdd($user)
    {
        return in_array($user['role'], ['admin', 'author']);
    }

    public function canEdit($user, Article $article)
    {
        if (in_array($user['role'], ['admin', 'author'])) {
            return true;
        }

        return $article->get('user_id') === $user['id'];
    }

    /**
     * Delete only own articles or any if you're an admin
     *
     * @param array $user
     * @param Article $article
     * @return bool
     */
    public function canDelete($user, Article $article)
    {
        if ($user['role'] === 'admin') {
            return true;
        }

        return $user['id'] === $article->get('user_id');
    }

}
