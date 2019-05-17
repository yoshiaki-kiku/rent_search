export function countUpDown(changeVlue, fromNum, toNum) {
    // どのくらい時間をかけてカウントするか
    const COUNT_DURATION = 2200;
    const startTime = Date.now();

    const timer = setInterval(() => {
        // 現在の経過時間
        const elapsedTime = Date.now() - startTime;
        // 処理
        const progress = elapsedTime / COUNT_DURATION;
        console.log(progress);

        // 指定期間以下は処理を続ける
        if (progress < 1) {
            changeVlue = Math.floor(fromNum + progress * (toNum - fromNum));
        } else {
            changeVlue = toNum;
            clearInterval(timer);
        }
    }, 16);
}
