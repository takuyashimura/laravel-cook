import axios from "axios";
import { useEffect, useState } from "react";

type cookingList = {
    id: number;
    menu_id: number;
};

const CookingList = () => {
    const [cookingList, setCookingList] = useState<[cookingList] | undefined>(
        undefined
    );

    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get(
                    "http://localhost:8888/api/cooking_list"
                );
                console.log("res.data", res.data);
                setCookingList(res.data.cooking_list);
                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);

    return (
        <>
            {cookingList &&
                cookingList.map((c) => (
                    <div key={c.id}>
                        <p>{c.menu_id}</p>
                    </div>
                ))}
        </>
    );
};

export default CookingList;
