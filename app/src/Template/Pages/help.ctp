<?= $this->Html->css('help.css') ?>
<div id="modal_help_coordinatesbattle_battle">
    <div class="help_window">
        このページでは，提示される2つのコーディネートから<span>自分の好きなコーディネートを選ぶゲーム</span>で遊べます<br><br>
        気になったコーディネートは，コーディネート下の「コーディネートの詳細」ボタンで見ることができます<br>
        色々なコーディネートを見て楽しみましょう！<br><br>
        ゲームをやめる時には，下に表示される「ゲーム終了！」ボタンを押しましょう<br>
        自分のセンスが<span>どの程度他のみんなと合ってるか</span>がわかります
    </div>
</div>

<div id="modal_help_coordinatesbattle_result">
    <div class="help_window">
        このページでは，さっきまで遊んでいた<span>ゲームの結果を見る</span>ことができます<br><br>
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
        このページでは，<span>コーディネートを投稿</span>できます<br><br>
        先ほどのページで選んだ<span>アイテムの配置や大きさの調節</span>をしてコーディネートを完成させましょう！<br>
        アイテムの配置が終わったら「投稿ボタン」をクリック<br>
        実際にコーディネートが作成されます<br><br>
        もしも別のアイテムを選びたくなったら<span>「アイテムを選びなおす」</span>でアイテム選択画面に戻りましょう
    </div>
</div>

<div id="modal_help_rankings_view">
    <div class="help_window">
        このページでは，みんなから人気のある<span>コーディネートのランキング</span>を見ることができます<br><br>
        このランキングは <?= $this->Html->Link("2択ゲーム", ["controller" => "Coordinatesbattle", "action" => "battle"]) ?>
        でみんなから選ばれた回数によって決められているので，<br>
        1位のコーディネートは，<span>多くの人が好きなコーディネート</span>です<br><br>
        自分に自信のない人は上位コーディネートの写真をクリック！<br>
        そのコーディネートの詳細画面から<span>服を購入</span>してみましょう！
    </div>
</div>

<div id="modal_help_users_view">
    <div class="help_window">
        このページでは，<span>自分の情報を確認</span>できます<br><br>
        自分の<span>おしゃれレベル</span>や，作成したコーディネート，<br>
        ゲーム中やコーディネート詳細画面からお気に入りに追加したコーディネートを見ることができます<br>
    </div>
</div>


<div id="modal_help_coordinates_view">
    <div class="help_window">
        このページでは，<span>コーディネートの詳細を確認できます</span><br><br>
        使用されているアイテムやコーディネートの合計金額，<br>
        気に入ったアイテムがあれば，お気に入りに入れることができます<br>
        お気に入りに入れたコーディネートは
        <?= $this->Html->Link("ユーザーページ", ["controller" => "Users", "action" => "view", $this->request->session()->read('Auth.User.id')])?>
        から再び見ることができます<br><br>
        また，気になったアイテムはこのページから購入することができます<br>
        好きなコーディネートも一式そろえることができます！
    </div>
</div>
