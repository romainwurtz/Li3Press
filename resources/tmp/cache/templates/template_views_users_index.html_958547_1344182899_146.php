    <h2>Users</h2>

    <ul>
        <?php foreach ($users as $user) { ?>
            <li><?php echo $h($user->username); ?></li>
        <?php } ?>
    </ul>