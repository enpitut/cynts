/**
 * controller の action へ POST メソッドで ajax による通信を行う
 * WARNING: コントローラ直下のURLでメソッド名のみで実行すると，パスの関係で失敗する
 * 絶対パスを指定した方が良い ex) /コントローラ名/アクション名
 *
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

/**
 * 指定したファイルの内容をテキストとして読み込む
 * jquery deffered を利用している
 * args_list は，deffered の then ブロック間で受け渡す値を複数保持しておくための引数
 * @param file_name
 * @param args_list
 */
function readHtml(file_name, args_list) {
    var dfd = $.Deferred();
    var httpObj = new XMLHttpRequest();
    httpObj.addEventListener('loadend', function(){
        if(httpObj.status === 200){
            //console.log(httpObj.response);
        }else{
            //console.error(httpObj.status+' '+httpObj.statusText);
        }
    });
    httpObj.open("GET", file_name, true);
    httpObj.onreadystatechange = function() {
        if (httpObj.readyState == 4) {
            var html = httpObj.responseText;
            if (args_list !== undefined) {
                dfd.resolve(args_list.concat(html));
            } else {
                dfd.resolve([html]);
            }
        }
    };
    httpObj.send(null);

    return dfd.promise();
}

