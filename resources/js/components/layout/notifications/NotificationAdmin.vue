<template>
    <div class="header-element notifications-dropdown">
        <!-- Start::header-link|dropdown-toggle -->
        <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
            <i class="bx bx-bell header-link-icon"></i>
            <span v-if="contactMessagesUnreadCount > 0" class="badge bg-secondary rounded-pill header-icon-badge pulse pulse-secondary" id="notification-icon-badge">{{ contactMessagesUnreadCount }}</span>
        </a>
        <!-- End::header-link|dropdown-toggle -->
        <!-- Start::main-header-dropdown -->
        <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
            <div class="p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="mb-0 fs-17 fw-semibold">{{ $t("notification.contact_messages_notifications")}}</p>
                    <span class="badge bg-secondary-transparent" id="notifiation-data">{{ contactMessagesUnreadCount }} {{$t('notification.unRead')}}</span>
                </div>
            </div>
            <div class="dropdown-divider"></div>
            <template v-if="contactMessages.length > 0">
                <ul class="list-unstyled mb-0 overflow-scroll" id="header-notification-scroll">
                    <li class="dropdown-item" :key="index" v-for="(message, index) in contactMessages" :class="{'opacity-50': message.is_read}">
                        <div class="d-flex align-items-start" >
                            <div class="pe-2">
                                <span class="avatar avatar-md bg-primary-transparent avatar-rounded">
                                    <i class="bx bx-envelope fs-18"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="mb-0 fw-semibold">
                                        <router-link
                                            :to="{
                                                name: 'contactMessage',
                                            }"
                                            @click="markAsRead(message.id)"
                                        >
                                            {{ message.name }}
                                        </router-link>
                                    </p>
                                    <p class="mb-0 text-muted fs-12">
                                        {{ message.subject }}
                                    </p>
                                    <p class="mb-0 text-muted fs-11 mt-1" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ message.message }}
                                    </p>
                                    <span class="text-muted fw-normal fs-12 header-notification-text">{{ message.created_at }}</span>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" @click.prevent="markAsRead(message.id)" class="min-w-fit-content text-muted me-1 dropdown-item-close1">
                                        <i class="ti ti-check fs-16" v-if="!message.is_read"></i>
                                        <i class="ti ti-x fs-16" v-else></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </template>

            <div v-else class="p-5 empty-item1">
                <div class="text-center">
                    <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                        <i class="ri-notification-off-line fs-2"></i>
                    </span>
                    <h6 class="fw-semibold mt-3">{{ $t("notification.no_new_contact_messages") }}</h6>
                </div>
            </div>
            <div class="p-3 empty-header-item1 border-top">
                <div class="d-grid">
                    <router-link
                        class="btn btn-primary"
                        :to="{
                            name: 'contactMessage',
                        }"
                    >
                        {{ $t("global.view_all_notifications") }}
                    </router-link>
                </div>
            </div>
        </div>
        <!-- End::main-header-dropdown -->
    </div>
</template>

<script>
import { ref, onMounted, onUnmounted, watch } from "vue";
import { useI18n } from "vue-i18n";
import adminApi from "../../../api/adminAxios";
import { useStore } from "vuex";

export default {
    name: "notification",
    setup() {
        let contactMessages = ref([]);
        let contactMessagesUnreadCount = ref(0);
        const store = useStore();
        const { t, locale } = useI18n();
        const admin = store.state?.authAdmin?.user;
        let echoChannel = null;


        // Fetch unread count
        const fetchUnreadCount = () => {
            if (!admin) {
                return;
            }

            adminApi
                .get(`/dashboard/notifications/unread-count`)
                .then((res) => {
                    // Handle response structure: { message: '', data: { count: X } }
                    let count = 0;

                    if (res.data) {
                        if (res.data.data && typeof res.data.data.count === 'number') {
                            count = res.data.data.count;
                        } else if (res.data.data && typeof res.data.data === 'number') {
                            count = res.data.data;
                        } else if (typeof res.data.count === 'number') {
                            count = res.data.count;
                        } else if (res.data.data && res.data.data.data && typeof res.data.data.data.count === 'number') {
                            count = res.data.data.data.count;
                        }
                    }

                    contactMessagesUnreadCount.value = count;
                })
                .catch((err) => {
                    contactMessagesUnreadCount.value = 0;
                });
        };

        // Fetch recent contact messages (last 5 unread)
        const fetchRecentMessages = () => {
            if (!admin) {
                return;
            }

            adminApi
                .get(`/dashboard/notifications`, {
                    params: {
                        filter: 'unread',
                        per_page: 5
                    }
                })
                .then((res) => {
                    // Handle both array and paginated response
                    if (Array.isArray(res.data.data)) {
                        contactMessages.value = res.data.data;
                    } else if (res.data.data && Array.isArray(res.data.data.data)) {
                        contactMessages.value = res.data.data.data;
                    } else {
                        contactMessages.value = [];
                    }
                })
                .catch((err) => {
                    contactMessages.value = [];
                });
        };

        // Mark message as read
        const markAsRead = (id) => {
            if (admin) {
                adminApi
                    .post(`/dashboard/notifications/${id}/read`)
                    .then((res) => {
                        // Update local state
                        const message = contactMessages.value.find(m => m.id === id);
                        if (message) {
                            message.is_read = true;
                            message.read_at = res.data.data.read_at;
                        }
                        // Refresh count
                        fetchUnreadCount();
                        // Remove from list if all are read
                        contactMessages.value = contactMessages.value.filter(m => !m.is_read);
                    })
                    .catch((err) => {
                        // Error handling
                    });
            }
        };

        /**
         * Setup Pusher listener for real-time notifications
         * Uses public channel (admin.notifications) - no authentication required
         */
        const setupPusherListener = (retryCount = 0) => {
            if (!admin) {
                return;
            }

            // Wait for Echo to be initialized
            if (!window.Echo) {
                if (retryCount < 10) {
                    setTimeout(() => {
                        setupPusherListener(retryCount + 1);
                    }, 500);
                }
                return;
            }

            try {
                // Leave existing channel if any
                if (echoChannel) {
                    window.Echo.leave('admin.notifications');
                    echoChannel = null;
                }

                // Subscribe to public channel (not private)
                echoChannel = window.Echo.channel('admin.notifications')
                    .listen('.contact-message.created', (data) => {
                        // Log received data to console
                        console.log('🔔 Received contact message notification:', data);

                        // Add new message to the list
                        const newMessage = {
                            id: data.id,
                            name: data.name,
                            email: data.email,
                            phone: data.phone,
                            subject: data.subject,
                            message: data.message,
                            is_read: data.is_read || false,
                            created_at: new Date(data.created_at).toLocaleString('ar-EG', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit'
                            })
                        };

                        // Add to messages list
                        contactMessages.value.unshift(newMessage);

                        // Update unread count (increment)
                        contactMessagesUnreadCount.value += 1;

                        // Keep only last 5 messages
                        if (contactMessages.value.length > 5) {
                            contactMessages.value = contactMessages.value.slice(0, 5);
                        }

                        // Show toast notification if available
                        if (typeof VanillaToasts !== 'undefined') {
                            VanillaToasts.create({
                                title: t('notification.new_contact_message_from'),
                                text: data.name,
                                type: "info",
                                timeout: 5000,
                                positionClass: locale.value === "en" ? "topLeft" : "topRight",
                            });
                        }
                    });

                console.log('✅ Successfully subscribed to admin.notifications channel');

                // Refresh messages after successful subscription
                setTimeout(() => {
                    fetchRecentMessages();
                    fetchUnreadCount();
                }, 500);
            } catch (error) {
                console.error('❌ Error setting up Pusher listener:', error);
                // Retry after 2 seconds
                if (retryCount < 5) {
                    setTimeout(() => {
                        setupPusherListener(retryCount + 1);
                    }, 2000);
                }
            }
        };

        onMounted(() => {
            if (!admin) {
                return;
            }

            // Initial fetch immediately
            fetchUnreadCount();
            fetchRecentMessages();

            // Setup Pusher listener - will retry if Echo is not ready
            setupPusherListener();

            // Also try after a delay to ensure Echo is initialized
            setTimeout(() => {
                if (!echoChannel && window.Echo) {
                    setupPusherListener();
                }

                // Re-fetch data
                fetchUnreadCount();
                fetchRecentMessages();
            }, 2000);

            // Additional retry after 5 seconds
            setTimeout(() => {
                if (!echoChannel && window.Echo) {
                    setupPusherListener();
                }

                // Re-fetch data again
                fetchUnreadCount();
                fetchRecentMessages();
            }, 5000);

            // Setup SimpleBar for scroll
            setTimeout(() => {
                let myHeadernotification = document.getElementById("header-notification-scroll");
                if (myHeadernotification) {
                    new SimpleBar(myHeadernotification, { autoHide: true });
                }
            }, 1000);
        });

        onUnmounted(() => {
            // Clean up Pusher listener
            if (echoChannel) {
                window.Echo.leave('admin.notifications');
            }
        });


        return {
            contactMessages,
            contactMessagesUnreadCount,
            markAsRead,
            fetchUnreadCount,
            fetchRecentMessages
        };
    }
};
</script>

<style scoped>
.notifications .media > .avatar {
    margin: 0 10px !important;
}
.opacity-50 {
    opacity: 0.6;
}
</style>

<style>
/* Badge styling - positioned correctly above the icon, smaller size */
#notification-icon-badge {
    position: absolute !important;
    min-width: 16px !important;
    height: 16px !important;
    padding: 0 3px !important;
    font-size: 9px !important;
    line-height: 16px !important;
    text-align: center !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    z-index: 999 !important;
    border-radius: 50% !important;
}

#messageDropdown {
    position: relative !important;
}
</style>
