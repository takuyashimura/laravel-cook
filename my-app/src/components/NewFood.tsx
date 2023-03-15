import { useState } from "react";

const NewFood = () => {
    const [count, setCount] = useState(0);

    const OnClickCountUp = () => {
        setCount(count + 1);
    };
    const OnClickCountDown = () => {
        setCount(count - 1);
    };

    return (
        <>
            <div>
                <input type="text" name="name" placeholder="登録する食材名" />
                <p>{count}</p>
                <button onClick={OnClickCountUp}>+</button>
                <button onClick={OnClickCountDown}>-</button>
            </div>
            <div>
                <button type="submit">新しい食材を追加</button>
            </div>
        </>
    );
};

export default NewFood;
