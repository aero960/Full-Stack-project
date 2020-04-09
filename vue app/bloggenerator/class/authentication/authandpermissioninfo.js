export const permissionParser = (permission) => {

    if (permission <= 1)
        return {rang: "normal"};
    if (permission <= 2)
        return {rang: "premium"};
    if (permission <= 3)
        return {rang: "admin"};
    if (permission >= 4)
        return {rang: "webmaster"};




};