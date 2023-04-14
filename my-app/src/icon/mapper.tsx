import React from "react";
import { GiCook, GiRiceCooker } from "react-icons/gi";
import { GoTrashcan } from "react-icons/go";
import { TfiShoppingCart } from "react-icons/tfi";
import { MdMenuBook, MdOutlineWarehouse } from "react-icons/md";
import { AiFillSetting } from "react-icons/ai";

const Icon = ({ name }: any) => {
    switch (name) {
        case "cook":
            return <GiCook />;
        case "trashcan":
            return <GoTrashcan />;
        case "pot":
            return <GiRiceCooker />;
        case "cart":
            return <TfiShoppingCart />;
        case "menu":
            return <MdMenuBook />;
        case "home":
            return <MdOutlineWarehouse />;
        case "setting":
            return <AiFillSetting />;

        default:
            return null;
    }
};

export default Icon;
