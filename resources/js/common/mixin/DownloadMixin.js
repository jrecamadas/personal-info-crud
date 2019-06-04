export default {
    methods: {
        downloadFile(uri, filename) {

            let fileName = filename.substr(filename.lastIndexOf('/') + 1);

            axios({
                url: uri,
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]))
                const link = document.createElement('a')
                link.href = url
                link.setAttribute('download', fileName)
                document.body.appendChild(link)
                link.click()
            })
        }
    }
}
