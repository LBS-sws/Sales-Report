<?php
$this->pageTitle = Yii::app()->name . ' - Chat';
header('Access-Control-Allow-Origin: http://dr.lbs.com');
header('Access-Control-Allow-Methods: GET, OPTIONS'); // Add any additional allowed methods
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept'); // Add any additional allowed headers

?>

<!-- 引入样式 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>客服manager</title>
    <link rel="stylesheet" href="./../../css/element-ui.css">
    <style>
        .chat-container {
            width: 100%;
            height: 100%;
        }

        .chat-sidebar-cust {
            width: 20%;
            background-color: #f0f0f0;
            padding: 20px;
            float: left;
        }

        .chat-chat {
            width: 50%;
            float: left;
        }

        .chat-header {
            height: 60px;
            background-color: #f0f0f0;
            position: sticky;
            top: 0;
            z-index: 1;
            padding: 10px;
            font-size: 18px;
        }

        .chat-messages {
            margin-bottom: 20px;
            height: calc(100vh - 200px); /* Set a fixed height for the container */
            overflow-y: scroll;
        }

        .chat-no-messages,
        .chat-no-customer {
            font-size: 18px;
            color: #888;
            text-align: center;
            margin-top: 100px;
        }

        .chat-message {
            margin-bottom: 20px;
        }

        .chat-message-container {
            display: flex;
            justify-content: flex-start;
        }

        .chat-sender-container {
            justify-content: flex-end;
        }

        .chat-message-container .chat-content {
            padding: 10px;
            border-radius: 10px;
            max-width: 70%;
            position: relative;
        }

        .chat-message .chat-sender {
            font-weight: bold;
            margin-bottom: 5px;
            align-self: flex-start;
        }

        .chat-message .chat-timestamp {
            font-size: 12px;
            color: #888;
            align-self: flex-end;
        }

        .chat-message .chat-sender-message {
            background-color: #e8f0fe;
        }

        .chat-message .chat-receiver-message {
            background-color: #dcf8c6;
        }

        .chat-message-container.chat-sender-container .chat-content {
            border-bottom-right-radius: 3px;
        }

        .chat-message-container.chat-receiver-container .chat-content {
            border-bottom-left-radius: 3px;
        }

        .chat-message-container.chat-sender-container .chat-content::before {
            content: "";
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 8px 10px 8px 0;
            border-color: transparent #e8f0fe transparent transparent;
            right: -10px;
            bottom: 0;
        }

        .chat-message-container.chat-receiver-container .chat-content::before {
            content: "";
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 8px 0 8px 10px;
            border-color: transparent transparent transparent #dcf8c6;
            left: -10px;
            bottom: 0;
        }

        .chat-input-container {
            display: flex;
            align-items: center;
            padding: 20px;
        }

        .chat-input-container input {
            flex: 1;
            height: 50px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0 10px;
        }

        .chat-input-container button {
            margin-left: 10px;
        }

        .chat-message-container.chat-sender-container .chat-content {
            background-color: #e8f0fe;
        }

        .chat-message-container.chat-receiver-container .chat-content {
            background-color: #dcf8c6;
        }

        .chat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            background-color: #f0f0f0;
            position: sticky;
            top: 0;
            z-index: 1;
            padding: 10px;
            font-size: 18px;
        }

        .chat-header-content {
            flex: 1;
        }

        .chat-emoji-selector-row {
            margin: 0px;
        }

        .chat-emoji-selector-row .el-col {
            padding: 0px;
        }

        #loading-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .chat-spinner {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .chat-badge {
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            margin-left: 5px;
        }

        .chat-search-container {
            display: flex;
            align-items: center;
        }

        .chat-search-container input {
            margin-right: 10px;
        }

        .chat-load-more-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .chat-left-customer {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div id="app">
    <div class="chat-container">
        <div id="loading-spinner" v-if="loading">
            <div class="chat-spinner"></div>
        </div>
        <div class="chat-sidebar-cust">
            <h4>访客列表</h4>
            <div class="chat-search-container">
                <el-input v-model="searchQuery" placeholder="输入客户名称" clearable></el-input>
                <el-button type="primary" @click="getCustomerList">查询</el-button>
            </div>
            <div v-if="loadingCustomerList" class="loading">客户列表加载中...</div> <!-- Add this line -->

            <el-menu class="chat-left-customer" :default-active="String(activeVisitor)" @select="selectVisitor">
                <el-menu-item v-if="visitors.length === 0">暂无数据</el-menu-item>
                <el-menu-item v-for="visitor in visitors" :key="visitor.id" :index="String(visitor.customer_id)"
                              @click="selectVisitor(visitor.customer_id)">
                    {{ visitor.customer_name }}
                    <span v-if="newMessageCount[visitor.customer_id]"
                          class="chat-badge">{{ newMessageCount[visitor.customer_id] }}</span>
                </el-menu-item>
            </el-menu>
            <el-pagination
                    v-if="visitors.length > 0"
                    @current-change="handlePageChange"
                    :current-page="currentPage"
                    :page-size="pageSize"
                    :total="totalVisitors"
                    :last-page="lastPage"
                    layout="prev, pager, next"
            ></el-pagination>
        </div>
        <div class="chat-chat">
            <div class="chat-header">
                <div class="chat-header-content">
                    <h3 v-if="activeVisitor != null">客户 ID: {{ activeVisitor }}</h3>
                    <h3 v-else>请选择客户以回复消息</h3>
                </div>
                <div class="chat-calendar">
                    选择日期：
                    <el-date-picker v-model="selectedDate" type="date" placeholder="选择日期" format="yyyy-MM-dd"
                                    value-format="yyyy-MM-dd"></el-date-picker>
                    <el-button type="primary" @click="getHistoryMessage()">查询</el-button>
                </div>
            </div>
            <div class="chat-messages" ref="messagesContainer">
                <div v-if="activeVisitor">
                    <div v-if="loadingMessages" class="loading">加载中...</div>
                    <div v-if="messagesByCustomerId[activeVisitor] && messagesByCustomerId[activeVisitor].length > 0">

                        <div v-if="activeVisitor && !loadingMessages" class="chat-load-more-container">
                            <div class="centered-text">
                                <el-link v-if="!noMoreMessages" type="primary" @click="loadMoreMessages">加载更多消息
                                </el-link>
                                <el-link v-else type="primary" @click="noMessages">到底啦~</el-link>
                            </div>
                        </div>

                        <div v-for="(message, index) in messagesByCustomerId[activeVisitor]"
                             :key="`${activeVisitor}-${message.id}-${index}`" class="chat-message">
                            <div class="chat-message-container"
                                 :class="{'chat-sender-container': message.is_staff, 'chat-receiver-container': !message.is_staff}">
                                <div class="chat-content"
                                     :class="{'chat-sender-message': message.is_staff, 'chat-receiver-message': !message.is_staff}">
                                    <div>{{ message.content }}</div>
                                    <div class="chat-timestamp">{{ message.timestamp }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="chat-no-messages">该客户暂无消息</div>
                </div>
                <div v-else class="chat-no-customer">
                    <div class="centered-text">请选择一个客户以查看消息</div>
                </div>
            </div>
            <div class="chat-input-container">
                <el-popover placement="top" trigger="click" v-model="showEmojiSelector">
        <span slot="reference">
            😁
        </span>
                    <el-row class="chat-emoji-selector-row">
                        <el-col v-for="emoji in emojis" :key="emoji" :span="1">
                            <el-button @click="appendEmoji(emoji)">{{ emoji }}</el-button>
                        </el-col>
                    </el-row>
                </el-popover>
                <input v-model="newMessage" placeholder="请输入你要回复的内容..." @keydown.enter="sendMessage" clearable>
                <el-button type="primary" @click="sendMessage">发送</el-button>
            </div>
        </div>
    </div>
</div>

<script src="./../../js/vue.js"></script>
<script src="./../../js/element.js"></script>

<script src="<?php if (isset($api_url)) {
    echo $api_url;
} ?>static/axios_dist_axios.min.js"></script>

<script>
    new Vue({
        el: '#app',
        data: {
            activeVisitor: null,
            newMessageCount: {},
            visitors: [],
            messagesByCustomerId: {},
            selectedDate: '',
            messages: [],
            showEmojiSelector: false,
            emojis: ['😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘', '😗', '😙', '😚', '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩', '🥳', '😏', '😒', '😞', '😔', '😟', '😕', '🙁', '☹️', '😣', '😖', '😫', '😩', '🥺', '😢', '😭', '😤', '😠', '😡', '🤬', '🤯', '😳', '🥵', '🥶', '😱', '😨', '😰', '😥', '😓', '🤗', '🤔', '🤭', '🤫', '🤥', '😶', '😐', '😑', '😬', '🙄', '😯', '😦', '😧', '😮', '😲', '🥱', '😴', '🤤', '😪', '😵', '🤐', '🥴', '🤢', '🤮', '🤧', '😷', '🤒', '🤕', '🤑', '🤠', '😈', '👿', '👹', '👺', '🤡', '💩', '👻', '💀', '☠️', '👽', '👾', '🤖', '🎃', '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾'],

            newMessage: '',
            loading: false,
            loadingCust: false,
            loadingMessages: false, // Add this line
            websocket: null,
            websocketUrl: "<?php if (isset($wss)) {
                echo $wss;
            }?>",
            heartbeatInterval: 3000,
            reconnectInterval: 3000,
            currentPage: 1,
            pageSize: 15,
            historyCurrentPage: 1,
            historyPageSize: 15,
            searchQuery: '',
            city_id: "<?php if (isset($city)) {
                echo $city;
            }?>",
            apiUri: "<?php echo $api_url;?>",
            staff_id : "<?php if (isset($uid)) {
                echo $uid;
            } ?>",
            loadingCustomerList: false,
            noMoreMessages: false,
        },
        created() {
            this.loading = true;
            this.loadingCust = true;
            // this.connectWebSocket();
            this.selectedDate = this.getDate();
            this.getCustomerList();
            this.connectWebSocket();
        },
        mounted() {
            // const messagesContainer = this.$refs.messagesContainer;
            // messagesContainer.addEventListener('scroll', this.handleScroll);
        },
        methods: {
            noMessages() {
                this.$message({
                    message: '😃到底了，还点呢~',
                    type: 'warning'
                });
                return;
            },
            appendEmoji(emoji) {
                this.newMessage += emoji;
            },
            startHeartbeat() {
                this.heartbeatTimer = setInterval(() => {
                    if (this.websocket.readyState === WebSocket.OPEN) {
                        this.websocket.send(JSON.stringify({"state": 1, "type": "heartbeat"}));
                    }
                }, this.heartbeatInterval);
            },

            stopHeartbeat() {
                clearInterval(this.heartbeatTimer);
            },

            connectWebSocket() {

                let params = {
                    'city_id': this.city_id,
                    'is_staff': 1,
                    'staff_id': this.staff_id
                }
                let newData = JSON.stringify(params);
                this.websocket = new WebSocket(this.websocketUrl + `?${encodeURIComponent(newData)}`);

                this.websocket.onopen = () => {
                    console.log('WebSocket connection established');
                    // Start the heartbeat interval
                    this.startHeartbeat();
                };

                this.websocket.onmessage = (event) => {
                    console.log('Received message:', event.data);
                    const message = JSON.parse(event.data);
                    this.handleReceivedMessage(message);
                };

                this.websocket.onclose = event => {
                    console.log('WebSocket connection closed');
                    this.stopHeartbeat();
                    // Automatically attempt to reconnect
                    setTimeout(() => this.connectWebSocket(), this.reconnectInterval);
                };

                this.websocket.onerror = event => {
                    console.error('WebSocket error:', event);
                    this.websocket.close();
                };
            },

            handleReceivedMessage(message) {
                const {customer_id, content, is_staff} = message;
                if (customer_id && content) {
                    const newMessage = {
                        id: Number(new Date()),
                        content,
                        is_staff,
                        city: this.city_id,
                        timestamp: new Date().toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit',
                        }),
                        customer_id
                    };
                    this.notifyMe("消息来自：",customer_id)

                    if (!this.messagesByCustomerId[customer_id]) {
                        this.$set(this.messagesByCustomerId, customer_id, []);
                    }
                    this.messagesByCustomerId[customer_id].push(newMessage);

                    // Update new message count
                    if (!this.newMessageCount[customer_id]) {
                        this.$set(this.newMessageCount, customer_id, 0);
                    }
                    this.newMessageCount[customer_id]++;

                    // If the active visitor is the same as the customer_id, scroll to the bottom of the messages container
                    if (this.activeVisitor === customer_id) {
                        this.$set(this.newMessageCount, customer_id, 0);
                        this.$nextTick(() => {
                            this.scrollToBottom();
                        });
                    }
                }
            },

            notifyMe(notification_title, body) {
                if (Notification.permission !== "granted")
                    Notification.requestPermission();
                else {
                    //notification_title，通知标题
                    var notification = new Notification(notification_title, {
                        //显示通知的图标
                        //icon: '',
                        //通知的内容
                        body: body,
                    });

                    notification.onclick = function () {
                        parent.focus();
                        window.focus(); //just in case, older browsers
                        this.close();
                    };
                }
            },



            // handleScroll(event) {
            //     const messagesContainer = event.target;
            //     if (messagesContainer.scrollTop === 0 && this.historyCurrentPage < this.historyLastPage) {
            //         this.loadMoreMessages();
            //     }
            // },
            getDate() {
                var now = new Date();
                var year = now.getFullYear(); //得到年份
                var month = now.getMonth(); //得到月份
                var date = now.getDate(); //得到日期
                var hour = " 00:00:00"; //默认时分秒 如果传给后台的格式为年月日时分秒，就需要加这个，如若不需要，此行可忽略
                month = month + 1;
                month = month.toString().padStart(2, "0");
                date = date.toString().padStart(2, "0");
                var defaultDate = `${year}-${month}-${date}`;//
                return defaultDate;
            },
            getCustomerList() {
                axios.get(this.apiUri + 'customer/custinfo/getList', {
                    params: {
                        city: this.city_id,
                        page: this.currentPage,
                        list_rows: this.pageSize,
                        query: this.searchQuery // 搜索
                    }
                })
                    .then(response => {
                        this.visitors = response.data.data.data;
                        this.totalVisitors = response.data.data.total;
                        this.currentPage = response.data.data.current_page;
                        this.lastPage = response.data.data.last_page;
                        this.loadingCustomerList = false; // Set loading state to false
                        this.loading = false;

                        // Update unread message count for each visitor
                        this.visitors.forEach(visitor => {
                            const visitorId = visitor.customer_id;
                            const unreadCount = visitor.unread_count;
                            this.$set(this.newMessageCount, visitorId, unreadCount);
                        });
                    })
                    .catch(error => {
                        console.error(error);
                        this.loadingCustomerList = false; // Set loading state to false
                        this.loading = false;
                    });
            },
            handlePageChange(page) {
                this.currentPage = page;
                this.getCustomerList();
            },
            removeNewMessageCount(customer_id) {
                this.$set(this.newMessageCount, customer_id, 0);
            },
            selectVisitor(customer_id) {
                this.activeVisitor = customer_id;
                this.historyCurrentPage = 1;
                this.removeNewMessageCount(customer_id);
                // Set the cookie with the customer_id as the key
                document.cookie = `customer_id=${customer_id}`;
                this.getHistoryMessage();
                this.$nextTick(() => {
                    this.scrollToBottom();
                });


                // Set the currentStaffId
                // this.currentStaffId = 'admin';

                // Send customer_id and currentStaffId to the backend
                this.readMessageStatus()
                this.getHistoryMessage();
                this.$nextTick(() => {
                    this.scrollToBottom();
                });

                // Hide message count for the selected visitor
                if (this.newMessageCount[customer_id]) {
                    this.newMessageCount[customer_id] = 0;
                }
            },
            readMessageStatus(){
                axios.get(this.apiUri + 'customer/custinfo/changeStatus', {
                    params: {
                        customer_id: customer_id,
                        staff_id: this.staff_id
                    }
                })
                .then(response => {
                    if(response.data.code == 0){
                        console.log(customer_id+"消息标记为已读")
                    }
                    // Handle the response from the backend if needed
                })
                .catch(error => {
                    console.error(error);
                });
            }

            sendMessage() {
                var rand_id = Number(new Date());
                if (this.activeVisitor) {
                    if (this.newMessage.trim() !== '') {
                        const message = {
                            id: rand_id,
                            content: this.newMessage,
                            is_staff: 1,
                            city_id: this.city_id,
                            timestamp: new Date().toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit',
                            }),
                            staff_id: this.staff_id
                            customer_id: this.activeVisitor
                        };
                        // 存储 customer_id list
                        if (!this.messagesByCustomerId[this.activeVisitor]) {
                            this.messagesByCustomerId[this.activeVisitor] = [];
                        }
                        this.messagesByCustomerId[this.activeVisitor].push(message);
                        console.log(this.messagesByCustomerId)
                        this.websocket.send(JSON.stringify(message));

                        this.newMessage = '';
                        this.$nextTick(() => {
                            this.scrollToBottom();
                        });
                        this.$message({
                            message: '消息已发送',
                            type: 'success'
                        });
                        this.readMessageStatus()
                    } else {
                        this.$message({
                            message: '请输入要发送的消息内容',
                            type: 'error'
                        });
                    }
                } else {
                    this.$message({
                        message: '请先选择一个客户',
                        type: 'error'
                    });
                }
            },
            loadMoreMessages() {
                const messagesContainer = this.$refs.messagesContainer;
                const scrollPosition = messagesContainer.scrollHeight - messagesContainer.scrollTop;

                this.loadingMessages = true;
                this.historyCurrentPage++;
                this.getHistoryMessage(true);

                // Restore scroll position after loading more messages
                this.$nextTick(() => {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight - scrollPosition;
                });
            },
            getHistoryMessage(loadMore = false) {
                if (this.activeVisitor == null || this.activeVisitor == '') {
                    this.$message({
                        message: '请先选择一个客户',
                        type: 'error'
                    });
                    return;
                }

                let date = this.selectedDate;
                let url = this.apiUri + "customer/Records";
                this.loadingCust = true;
                this.loading = true; // Show loading animation

                axios.get(url, {
                    params: {
                        date: date,
                        city: this.city_id,
                        page: loadMore ? this.historyCurrentPage : 1,
                        list_rows: loadMore ? this.historyPageSize : this.pageSize,
                        customer_id: this.activeVisitor,
                    }
                })
                    .then(response => {
                        this.loading = false; // Hide loading animation
                        const loadedMessages = response.data.data.data;

                        // Create a new array with reversed order
                        const reversedMessages = loadedMessages.slice().reverse();

                        if (!this.messagesByCustomerId[this.activeVisitor]) {
                            this.messagesByCustomerId[this.activeVisitor] = [];
                        }

                        // Concatenate the reversed messages to the existing messages array
                        if (loadMore) {
                            // Prepend the loaded messages to the existing messages array
                            this.messagesByCustomerId[this.activeVisitor] = reversedMessages.concat(this.messagesByCustomerId[this.activeVisitor]);
                        } else {
                            // Replace the existing messages array with the loaded messages
                            this.messagesByCustomerId[this.activeVisitor] = reversedMessages;
                        }
                        this.noMoreMessages = reversedMessages.length === 0;

                        this.historyCurrentPage = response.data.data.current_page;
                        this.historyLastPage = response.data.data.last_page;
                        this.loadingCust = false;
                        this.loadingMessages = false; // Hide loading spinner

                        // Scroll to the bottom of the messages container
                        // this.$nextTick(() => {
                        //     const messagesContainer = this.$refs.messagesContainer;
                        //     messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        // });
                    })
                    .catch(error => {
                        console.error(error);
                        this.loading = false; // Hide loading animation
                        this.loadingCust = false;
                    });
            },
            scrollToBottom() {
                const messagesContainer = this.$refs.messagesContainer;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            },
        }
    })
</script>
</body>
</html>
