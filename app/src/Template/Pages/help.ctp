<?= $this->Html->css('help.css') ?>
<div id="modal_help_coordinatesbattle_battle">
    <div class="help_window">
        このページでは，<span>2つのコーディネートから自分の好きな方を選んでいくゲーム</span>で遊べます<br><br>
        気になったコーディネートは，コーディネート下の「コーディネートの詳細」ボタンで見ることができます<br>
        色々なコーディネートを見て楽しみましょう！<br><br>
        ゲームに満足したら，下に表示される「ゲーム終了！」ボタンを押しましょう<br>
        自分のセンスが<span>どの程度他のみんなと合ってるか</span>がわかります
    </div>
</div>

<div id="modal_help_coordinatesbattle_result">
    <div class="help_window">
        このページでは，<span>ゲームの結果を見る</span>ことができます<br><br>
        コーディネートの下のポイントはそのコーディネートの支持数，<br>
        赤い枠で囲まれてるコーディネートがあなたが選んだコーディネートです<br><br>
        みんなの支持度が高いコーディネートを選んでいくと
        <span>おしゃれレベル</span>が上がります！<br>
        どんどん自分のおしゃれレベルを上げていきましょう！<br>
    </div>
</div>

<div id="modal_help_coordinates_create">
    <div class="help_window">
        このページでは，<span>自分だけのコーディネート</span>が作れます<br><br>
        アイテム一覧から好きなアイテムを Pick して「コーディネートを作成」！<br>
        コーディネート投稿ページに移ります<br><br>
        <span>色や種類でアイテムの絞り込み</span>もできます<br>
        ぜひ活用して素敵なコーディネートを作成してくださいね！
    </div>
</div>

<div id="modal_help_coordinates_post">
    <div class="help_window">
        アイテムの配置や大きさの調節をして<span>コーディネートの写真</span>を作ってください<br>
        性別，季節を決めたらコーディネート完成です<br>
    </div>
</div>

<div id="modal_help_rankings_view">
    <div class="help_window">
        このページでは<span>コーディネートの人気ランキング</span>を見ることができます<br><br>
        このランキングは <?= $this->Html->Link('コーディネートバトル', ["controller" => "Coordinatesbattle", "action" => "battle"]) ?>
        でみんなから選ばれた回数によって決められているので，<br>
        1位のコーディネートは，<span>多くの人が好きなコーディネート</span>です<br><br>
        服選びが苦手な人は上位コーディネートの写真を参考にしてみましょう<br>
    </div>
</div>

<div id="modal_help_coordinates_view">
    <div class="help_window">
        このページはコーディネートページです<br>
        このコーディネートが気に入ったら，「お気に入り」ボタンを押してみてください<br>
        お気に入りしたコーディネートは
        <?= $this->Html->Link("マイページ", ["controller" => "Users", "action" => "view", $this->request->session()->read('Auth.User.id')])?>
        から再び見ることができます<br><br>
    </div>
</div>
