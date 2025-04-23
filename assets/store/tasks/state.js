export const state = {
    // To achieve Reactivity with nested Objects, the state must be initialized with sample Objects
    tasks: [
        {
            id: 1,
            title: "Neue Aufgabe mit einem Comment",
            description: "Mehr Details zu dieser Aufgaben",
            status: 0,
            ownerId: 14,
            ownerName: "jpwittig",
            lastChange: "2024-05-23 15:00:00",
            priority: 0,
            synchron: false,
            comments: [
                {
                    id : 1,
                    text: "Sample Comment 1",
                    authorId: 23,
                    authorName: "hknorz",
                    date: "2024-05-25 15:00:00",
                    synchron: false,
                }
            ],
        },
        {
            id: 2,
            title: "Neue Aufgabe mit 2 Comments",
            description: "Mehr Details zu dieser Aufgaben",
            status: 2,
            ownerId: 23,
            ownerName: "hknorz",
            lastChange: "2024-05-24 15:00:00",
            priority: 1,
            synchron: false,
            comments: [
                {
                    id : 2,
                    text: "Sample Comment 2",
                    authorId: 14,
                    authorName: "jpwittig",
                    date: "2024-05-25 15:00:00",
                    synchron: false,
                },
                {
                    id : 3,
                    text: "Sample Comment 3",
                    authorId: 23,
                    authorName: "hknorz",
                    date: "2024-05-25 13:00:00",
                    synchron: false,
                },
                {
                    id : 4,
                    text: "Sample Comment 4",
                    authorId: 23,
                    authorName: "hknorz",
                    date: "2024-05-25 13:00:00",
                    synchron: false,
                },
                {
                    id : 5,
                    text: "Sample Comment 5",
                    authorId: 23,
                    authorName: "hknorz",
                    date: "2024-05-23 13:00:00",
                    synchron: false,
                }
            ],
        },
        {
            id: 3,
            title: "Neue Aufgabe",
            description: "Mehr Details zu dieser Aufgaben",
            status: 1,
            ownerId: 14,
            ownerName: "jpwittig",
            lastChange: "2024-05-24 15:00:00",
            priority: 2,
            synchron: false,
            comments: [],
        }
    ],
}