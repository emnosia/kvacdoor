<div class="container mt-5">
    <h1 class="text-center mb-5">KVacDoor GPT</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Conversation
                </div>
                <div class="card-body">
                    <div class="conversation">
                        <?php foreach(Gpt::getAll($AUTHUSER['discord_id'] . "2") as $conversation): ?>
                        <div class="bot-message">
                            <?= nl2br($conversation['message']); ?>
                        </div>
                        <hr>
                        <?php endforeach; ?>
                    </div>
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control" id="input-message" placeholder="Réponse...">
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>