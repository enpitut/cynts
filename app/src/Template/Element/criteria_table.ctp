<?php
/**
 * 要件
 *  - Controller から $sex_list が渡される必要がある
 *
 * 使用方法
 *  - didChangeCoordinatesCriteria() は，条件の設定が変更される度に呼び出される
 *   + 各 view 毎に定義すること
 *  - updateCriteriaJson() を呼び出すと，現在の条件に応じて変数 criteria_json に条件が json 配列として保持される
 *
 * 参考
 *  - Controller 側へ POST で送信する際は，JSON.stringify(criteria_json) で文字列に変換し，
 *    Criteria\CoordinatesCriteria::createQueryFromJson() を利用すると，絞り込み検索のためのクエリを生成できる
 */
?>

<table class="search_area">
    <?= $this->Form->create(null, ['name' => 'criteria_form']) ?>
    <tr>
        <td class="search_label">性別</td>
        <td class="search_value" id="sex">
            <?= $this->Form->input(
                'sex',
                [
                    'label' => '',
                    'options' => $sex_list,
                    'empty' => '指定なし',
                    'class' => 'criteria_value',
                    'onChange' => 'didChangeCoordinatesCriteria();'
                ]
            ); ?>
        </td>
    </tr>
    <tr>
        <td class="search_label">価格帯</td>
        <td class="search_value" id="price">
            <?= $this->Form->input(
                'price',
                [
                    'label' => '',
                    'options' => [
                        '0,1000' => '¥0 - ¥1000',
                        '1001,3000' => '¥1001 - ¥3000',
                        '3001,5000' => '¥3001 - ¥5000',
                        '5001,10000' => '¥5001 - ¥10000',
                        '10001,15000' => '¥10001 - ¥15000',
                        '15001,20000' => '¥15001 - ¥20000',
                    ],
                    'empty' => '指定なし',
                    'class' => 'criteria_value',
                    'onChange' => 'didChangeCoordinatesCriteria();'
                ]
            ); ?>
        </td>
    </tr>
    <tr>
        <td class="search_label">季節</td>
        <td>
            <?php
            echo "春" . $this->Form->checkbox(
                    'spring', [
                    'hiddenField' => false,
                    'value' => 'spring',
                    'onChange' => 'didChangeCoordinatesCriteria();'
                ]);
            echo "夏" . $this->Form->checkbox(
                    'summer', [
                    'hiddenField' => false,
                    'value' => 'summer',
                    'onChange' => 'didChangeCoordinatesCriteria();'
                ]);
            echo "秋" . $this->Form->checkbox(
                    'autumn', [
                    'hiddenField' => false,
                    'value' => 'autumn',
                    'onChange' => 'didChangeCoordinatesCriteria();'
                ]);
            echo "冬" . $this->Form->checkbox(
                    'winter', [
                    'hiddenField' => false,
                    'value' => 'winter',
                    'onChange' => 'didChangeCoordinatesCriteria();'
                ]);
            ?>
        </td>
    </tr>
</table>

<script>
    var criteria_json = {};

    /**
     * コーデの絞り込みの条件(性別，季節等)を格納している criteria_json の値を，
     * 現在のセレクト/チェックボックスの状態に応じて更新する
     *
     * 季節に関しては，春夏秋冬を4bitのビット列(選択されていれば1，そうでなければ0)として保持する
     */
    function updateCriteriaJson() {
        var select_forms = document.getElementsByClassName('criteria_value');
        var season_binary_string =
            ($("[name=spring]").prop("checked") ? "1" : "0") +
            ($("[name=summer]").prop("checked") ? "1" : "0") +
            ($("[name=autumn]").prop("checked") ? "1" : "0") +
            ($("[name=winter]").prop("checked") ? "1" : "0");
        if (season_binary_string === "0000") {
            delete criteria_json["season"];
        } else {
            criteria_json["season"] = season_binary_string;
        }

        for(var i=0,l=select_forms.length; l>i; i++)
        {
            var index = select_forms[i].selectedIndex;
            if (index != "") {
                criteria_json[select_forms[i].name] = select_forms[i].options[index].value;
            } else {
                delete criteria_json[select_forms[i].name];
            }
        }
    }
</script>
