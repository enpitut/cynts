/**
 * controller の action へ POST メソッドで ajax による通信を行う
 * @param action データ送信先の action
 * @param send_data action へ送信するデータ
 * @param args done ブロック等に引数でデータを渡したい場合には, ここに記述する
 * @returns {*}
 */
function sendPost(action, send_data, args) {
    return $.ajax({
        type: "POST",
        url: action,
        data: send_data,
        context: args
    })
}

