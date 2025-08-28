<h2>Керування користувачами</h2>

<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Логін</th>
            <th>Email</th>
            <th>Дата реєстрації</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= date('d.m.Y H:i', strtotime($user['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>