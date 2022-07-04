export function showNotifications(show, container)
{
    show?
    (() => {
        container.style.height = "0px";
        container.style.padding = "0px";
    })():
    (() => {
        container.style.height = "fit-content";
        container.style.padding = "5px 0px";
    })();

    return !show;
};