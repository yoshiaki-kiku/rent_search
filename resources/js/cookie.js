/**
 * cookieでフォームに初期値を与える
 * @param {*} valueTemplate
 */
export function getSearchValueFromCookie(valueTemplate) {
    let val = valueTemplate;

    document.cookie.split(";").forEach(cookie => {
        const [key, value] = cookie.split("=");

        // パース時にスペースが張ることがあるのでtrimで除去
        let newKey = key.replace("searchValues.", "").trim(" ");

        let arrType = ["area", "floor_plan", "option"];
        let singleType = ["rent_lower_limit", "rent_upper_limit", "age"];

        if (arrType.includes(newKey)) {
            let arr = [];

            if (value) {
                arr = value.split(",");
                arr = arr.map(function(value) {
                    return Number(value);
                });
            } else {
                arr = [];
            }

            val[newKey] = arr;
        } else if (singleType.includes(newKey)) {
            if (value && !isNaN(value)) {
                val[newKey] = value;
            } else {
                val[newKey] = null;
            }
        }
    });

    return val;
}

export function setSearchValueInCookie(searchValues) {
    document.cookie = "searchValues.area=" + searchValues.area.join(",");
    document.cookie =
        "searchValues.rent_lower_limit=" + searchValues.rent_lower_limit;
    document.cookie =
        "searchValues.rent_upper_limit=" + searchValues.rent_upper_limit;
    document.cookie =
        "searchValues.floor_plan=" + searchValues.floor_plan.join(",");
    document.cookie = "searchValues.age=" + searchValues.age;
    document.cookie = "searchValues.option=" + searchValues.option.join(",");
}

export function deleteCookie() {
    document.cookie = "searchValues.area=; max-age=0";
    document.cookie = "searchValues.rent_lower_limit=; max-age=0";
    document.cookie = "searchValues.rent_upper_limit=; max-age=0";
    document.cookie = "searchValues.floor_plan=; max-age=0";
    document.cookie = "searchValues.age=; max-age=0";
    document.cookie = "searchValues.option=; max-age=0";
}

/**
 * 指定したクッキーを取得
 * @param String searchKey
 */
export function getCookieValue(searchKey) {
    if (typeof searchKey === "undefined") {
        return "";
    }

    let val = "";

    // document.cookieで
    // 下記の形式で取れる
    // 「name=12345;token=67890;key=abcde」
    // 分解して配列化、ループして指定のキーを探して値を取る
    document.cookie.split(";").forEach(cookie => {
        let [key, value] = cookie.split("=");
        key = key.trim(" ");
        if (key === searchKey) {
            return (val = value);
        }
    });

    return val;
}
