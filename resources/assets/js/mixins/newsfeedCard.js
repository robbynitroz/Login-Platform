export const newsfeedCard = {

    data() {
        return {
            loading: false,
        }
    },

    methods: {
        save(param) {
            var save = false
            var data = {
                card_name: this.cardName,
                published: 'yes',
                belongs_to: this.selected,
                description: this.description,
                feed_content: this.feedContent,
                buttonText:this.buttonText,
                buttonLink:this.buttonLink
            }

            if (param === 'save') {
                this.loading = true;
                save = true;
                var url = '/newsfeeds/cards/new';
            } else if (param === 'edit') {
                this.loading = true;
                var url = '/newsfeeds/card/edit/' + this.cardID;

            }
            axios.post(url, data)
                .then(response => {
                    //this.lastID = response.data
                    if (this.imageUploaded) {
                        this.loading = true;
                        this.uploadImage(response.data, save);
                    } else {
                        this.loading = false;
                        this.success = true;
                        this.cardCreated = true;
                        if (save === true) {
                            setTimeout(() => {
                                return this.$router.push({name: 'Cards'})
                            }, 1000);
                        }
                    }

                })
                .catch(e => {
                    this.errors = true;
                });


        },

        uploadImage(id, save = false) {

            this.loading = true;
            let config = {
                onUploadProgress: progressEvent => {
                    this.completed = Math.floor((progressEvent.loaded * 100) / progressEvent.total);
                }
            }
            var data = new FormData();
            data.append('cardimg', document.getElementById('card-img').files[0]);
            axios.post('/newsfeeds/media/' + id, data, config
            )
                .then(response => {
                    this.loading = false;
                    //this.cardCreated = true;
                    this.headerImg = response.data;
                    this.imageUploaded = false;
                    if (save === true) {
                        this.loading = false;
                        this.success = true;
                        this.cardCreated = true;
                        if (save === true) {
                            setTimeout(() => {
                                return this.$router.push({name: 'Cards'})
                            }, 1000);
                        }
                    }
                })
                .catch(e => {
                    this.errors = true;
                });
        }
    },
}
