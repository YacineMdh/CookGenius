<?php
require_once __DIR__ . '/../../src/config.php';
?>
<style>
    .container {
        max-width: 400px;
        margin: 0 auto;
        padding: 2rem;
        background: #f4f4f4;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #5C3A1E;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
    }

    button {
        background: #2F855A;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s;
    }

    button:hover {
        background: #1E5840;
    }

    a {
        text-align: center;
        display: block;
        margin-top: 10px;
        color: #5C3A1E;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }
</style>
<div class="container">
    <form method="POST" action="/forgot-password">
        <h2><?= $lang['password_reset']; ?></h2>
        <div>
            <label><?= $lang['email']; ?>:</label>
            <input type="email" name="email" required>
        </div>
        <button type="submit"> <?= $lang['send_reset_link']; ?> </button>
    </form>
</div>