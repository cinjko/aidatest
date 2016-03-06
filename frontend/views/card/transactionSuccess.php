<div class="site-index">

    <div class="container">
        <div class="row">
            <h1 class="success">Success</h1>
            <table class="table table-hover">
                <tbody>
                    <thead>
                        <tr>
                            <th>Send sum</th>
                            <th>Receiver's card number</th>
                        </tr>
                    </thead>
                    <?php foreach ($user_transactions as $transaction) { ?>
                    <tr>
                        <td><?= $transaction->sum; ?></td>
                        <td><?php echo $transaction->card_number_receiver; ?></td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>