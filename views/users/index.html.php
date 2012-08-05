    <h2>Users</h2>

    <ul>
        <?php foreach ($users as $user) { ?>
            <li><?=$user->username; ?></li>
        <?php } ?>
    </ul>