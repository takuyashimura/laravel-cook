import { Wrap, WrapItem } from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import styled from "styled-components";

type Menus = {
    menu_id: number;
    name: string;
};
type MenuData = {
    id: number;
    name: string;
};

const Menu = () => {
    const [menus, setMenus] = useState<[Menus] | undefined>(undefined);
    const [menuData, setMenuData] = useState<[MenuData] | undefined>(undefined);

    // get↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get("http://localhost:8888/api/menu");

                setMenus(res.data.menus);
                //サイトで拾ってきたコードにはconsoleのコードはなかったので自分で追記
                console.log(res);

                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);
    // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
    // post↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    const navigate = useNavigate();

    const handlePost = (menu: any) => {
        axios
            .post("http://localhost:8888/api/menu_cook", { menu })
            .then((response) => {
                setMenuData(response.data);
                console.log("post", response.data);
                navigate("/MenuCook/", { state: response.data });
            })
            .catch((error) => {
                console.error(error);
            });
    };
    // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

    return (
        <div className="Food">
            <div>
                <a href="/newMenu/">新規メニュー追加</a>
            </div>

            <Wrap>
                {menus &&
                    menus.map((menu) => (
                        <WrapItem
                            key={menu.menu_id}
                            onClick={() => handlePost(menu)}
                        >
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
