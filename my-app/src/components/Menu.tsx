import { Wrap, WrapItem } from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";
import styled from "styled-components";

type Menus = {
    menu_id: number;
    name: string;
};

const Menu = () => {
    const [menus, setMenus] = useState<[Menus] | undefined>(undefined);

    // 先ほど作成したLaravelのAPIのURL、メニューから取得する
    const url = "http://localhost:8888/api/menu";

    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get(url);

                setMenus(res.data.menus);
                //サイトで拾ってきたコードにはconsoleのコードはなかったので自分で追記
                console.log(res);

                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);
    return (
        <div className="Food">
            <div>
                <a href="/newMenu/">新規メニュー追加</a>
            </div>

            <Wrap>
                {menus &&
                    menus.map((menu) => (
                        <WrapItem>
                            <SCord>
                                <p>{menu.name}</p>

                                <p>リンク先未設定</p>
                            </SCord>
                        </WrapItem>
                    ))}
            </Wrap>
        </div>
    );
};

const SCord = styled.div`
    border: solid 1px #ccc;
    border-radius: 8px;
    padding: 10px;
`;

export default Menu;
