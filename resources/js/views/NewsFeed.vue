<template>
    <div class="flex flex-col items-center py-4">
        <NewPost />

        <Post />
    </div>
</template>

<script>
import NewPost from "../components/NewPost";
import Post from "../components/Post";

export default {
    name: "NewsFeed",

    components: {
        NewPost,
        Post
    },
    data: () => {
        return {
            posts: []
        };
    },
    mounted() {
        axios
            .get("/api/posts")
            .then(res => {
                this.posts = res.data;
            })
            .catch(error => {
                console.log("Unable to fetch posts");
            });
    }
};
</script>

<style scoped></style>
