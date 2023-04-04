import { Button, Wrap, WrapItem, useDisclosure } from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import styled from "styled-components";
import { AlertDialogPageMenu } from "./AlertDialogPageMenu";
import { EditMenuModal } from "./EditMenuModal";
import { NewMenuModal } from "./NewMenuModal";
import { MenuCookModal } from "./MenuCookModal";

type Menus = {
    menu_id: number;
    name: string;
};

type DeleteMenu = {
    id: number;
    user_id: number;
    name: string;
};

type MenuName = {
    id: number;
    name: string;
};

type MenuData = {
    id: number;
    name: string;
    food_amount: number;
};

const Menu = () => {
    const [menus, setMenus] = useState<[Menus] | undefined>(undefined);
    const [deleteMenu, setDeleteMenu] = useState<DeleteMenu[] | undefined>(
        undefined
    );
    const [menuName, setMenuName] = useState<MenuName[] | undefined>(undefined);
    const [menuData, setMenuData] = useState<MenuData[] | undefined>(undefined);
    const [choiceMenu, setChoiceMenu] = useState<any>();

    const {
        isOpen: isAlert,
        onOpen: onAlert,
        onClose: endAlert,
    } = useDisclosure();
    const {
        isOpen: isEdit,
        onOpen: onEdit,
        onClose: endEdit,
    } = useDisclosure();
    const { isOpen: isNew, onOpen: onNew, onClose: endNew } = useDisclosure();
    const {
        isOpen: isChoice,
        onOpen: onChoice,
        onClose: endChoice,
    } = useDisclosure();

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
    // 食材選択画面へ
    const handlePost = (menu: any) => {
        axios
            .post("http://localhost:8888/api/menu_cook", { menu })
            .then((response) => {
                console.log("post", response.data);
                navigate("/MenuCook/", { state: response.data });
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const ClickChoice = (menu: any) => {
        axios
            .post("http://localhost:8888/api/menu_cook", { menu })
            .then((response) => {
                setChoiceMenu(response.data);
                onChoice();
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const handlePost1 = (menu: any) => {
        axios
            .post("http://localhost:8888/api/menu_edit", { menu })
            .then((response) => {
                console.log("post1", response.data);
                navigate("/EditMenu/", { state: response.data });
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const ClickAlert = (menu: any) => {
        setDeleteMenu(menu);
        onAlert();
    };

    const clickEdit = (menu: any) => {
        axios
            .post("http://localhost:8888/api/menu_edit", { menu })
            .then((response) => {
                console.log("post1", response.data.menuData);
                console.log("post2", response.data.foodArray);
                setMenuName(response.data.menuData);
                setMenuData(response.data.foodArray);
                onEdit();

                // navigate("/EditMenu/", { state: response.data });
            })
            .catch((error) => {
                console.error(error);
            });
    };

    // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

    return (
        <div className="Food">
            <Button onClick={onNew}>新規メニュー追加</Button>

            <Wrap>
                {menus &&
                    menus.map((menu) => (
                        <WrapItem key={menu.menu_id}>
                            <>
                                <SCord>
                                    <p>{menu.name}</p>
                                    <Button
                                        style={{ border: "1px solid black" }}
                                        // onClick={() => handlePost(menu)}
                                        onClick={() => ClickChoice(menu)}
                                        _hover={{
                                            cursor: "pointer",
                                            opacity: 0.8,
                                        }}
                                    >
                                        選択する
                                    </Button>
                                    <br></br>
                                    <Button
                                        colorScheme="teal"
                                        style={{ border: "1px solid black" }}
                                        // onClick={() => handlePost1(menu)}
                                        onClick={() => clickEdit(menu)}
                                        _hover={{
                                            cursor: "pointer",
                                            opacity: 0.8,
                                        }}
                                    >
                                        編集
                                    </Button>
                                    <Button
                                        colorScheme="red"
                                        style={{ border: "1px solid black" }}
                                        // onClick={() => handlePost2(menu)}
                                        onClick={() => ClickAlert(menu)}
                                        _hover={{
                                            cursor: "pointer",
                                            opacity: 0.8,
                                        }}
                                    >
                                        削除
                                    </Button>
                                </SCord>
                            </>
                        </WrapItem>
                    ))}
            </Wrap>
            <AlertDialogPageMenu
                isOpen={isAlert}
                onClose={endAlert}
                deleteMenu={deleteMenu}
            />
            <EditMenuModal
                isOpen={isEdit}
                onClose={endEdit}
                menuName={menuName}
                menuData={menuData}
            />
            <NewMenuModal isOpen={isNew} onClose={endNew} />
            <MenuCookModal
                isOpen={isChoice}
                onClose={endChoice}
                choiceMenu={choiceMenu}
            />
        </div>
    );
};

const SCord = styled.div`
    border: solid 1px #ccc;
    border-radius: 8px;
    padding: 10px;
`;

export default Menu;
