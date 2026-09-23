import { Calendar } from '@fullcalendar/core'; // fullcalendarのクラスをインポート
import dayGridPlugin from '@fullcalendar/daygrid'; // 月表示（グリッド形式）のプラグインをインポート


/*****
- HTMLの解析が完了後、DOM要素が使用できる状態になってから実行する処理
- DOMができていない状態でgetElementByIdを使用するとnullになる
******/
document.addEventListener('DOMContentLoaded', () => {
    const calendarE1 = document.getElementById('calendar'); //calendar.blade.php内の<div id="calendar">を取得
    if (!calendarE1) return; // カレンダー以外の画面や、calendar要素を取得できなかった場合は、以降の処理を実行しない

    
    const events = JSON.parse(calendarE1.dataset.events);
    /* 以下例の様な形式になるようにするのが、JSON.parse
    => [
        { title: "買い物", start: "2026-09-25" },
        { title: "資料作成", start: "2026-09-30" }
    ]
    */

    const calendar = new Calendar(calendarE1,{ //取得したcalendarE1をFullCalendarに紐づけてインスタンス化する
        plugins: [dayGridPlugin], // グリッド表示機能を有効
        initialView: 'dayGridMonth', // 初期表示は月表示
        events: events, // 表示するデータの指定
    });

    calendar.render(); // カレンダーを描画する
})