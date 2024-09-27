<?php

session_start();
if (!isset($_SESSION['user']['id'])) {
    die();
}

if (isset($_SESSION['user']['id'])) {
    require_once '../../app/Models/includes.php';
    if (!User::isAuthentified() || !CSRF::isAjaxRequest() || !User::isExist($_GET['id'])) {
        die("Bad request");
    }

    $comments = Profile::GetAllCommentsFromUser($_GET['id']);

    function mention($match)
    {
        return '<a href="' . $match[1] . '">' . $match[0] . '</a>';
    }

?>

    <?php foreach ($comments as $comment) : ?>
        <?php $date = new DateTime($comment["created_at"]); ?>
        <?php $content = preg_replace_callback('#@[A-Za-z0-9]+#', 'mention', $comment['content']); ?>
        <div class="card">
            <div class="card-body">
                <img src="<?= htmlentities(User::GetUser($comment['user_id'])['avatar']); ?>" class="rounded-circle avatar-sm" onerror="this.onerror=null; this.src='https://i.imgur.com/vXzHaQe.png'">
                <a style="color:white" href="<?= User::GetUser($comment['user_id'])['id']; ?>"><u><?= htmlentities(User::GetUser($comment['user_id'])['username']); ?></u></a> | <?= CSRF::TimeAgo($date->getTimestamp()) ?><br><br><?= nl2br(htmlentities($content)); ?>
            </div>
        </div>
<?php endforeach;
}
?>