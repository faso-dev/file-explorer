class FileExplorer {
    onClick(callback) {
        document.addEventListener('click', e => {
            let target = e.target
            if (target && !(target instanceof HTMLLIElement)) {
                target = target.parentElement
            }

            if (
                target instanceof HTMLLIElement &&
                target.classList.contains('directory')
            ) {
                closeOtherFolders(target)
                target.classList.toggle('active')
                target.querySelector('i')?.classList?.add('open')
                callback(target)
            }
        })

        const closeOtherFolders = (target) => {
            document.querySelectorAll('li.directory.active')
                .forEach(el => {
                    if (target.parentElement.classList.contains('directories')) {
                        el.classList.remove('active')
                        el.querySelector('i')?.classList?.remove('open')
                    }
                })
        }
    }
}