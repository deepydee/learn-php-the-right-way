Home Page

<form action="/upload" method="post" enctype="multipart/form-data">
    <input type="file" name="receipt">
    <button type="submit">Upload</button>
</form>

<hr>

<?php if (! empty($invoice)): ?>
    Invoice ID: <?= htmlspecialchars($invoice->id, ENT_QUOTES) ?> <br>
    Invoice Amount: <?= htmlspecialchars($invoice->amount, ENT_QUOTES) ?> <br>
    User: <?= htmlspecialchars($invoice->full_name, ENT_QUOTES) ?> <br>
<?php endif ?>
