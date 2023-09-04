
# 損益分配
1. 重新計算期間可分配權益
2. 

Model: 資料庫相關Model
Repository: 專注對Model操作行為封裝fetch insert delete update
Module: 商業邏輯，封裝單純商業邏輯 ex: weight = commitment/5000 
Service: 商業邏輯組合整合呼叫

假定 - 計算損益時帳戶出入金資料都是正確
    取得上期結餘
    取得當期變動
    計算可分配損益
        等於 0 跳過
    計算權重
    計算總權重
    取得資產總損益
    計算每權重損益
    計算個人損益
    計算admin損益
    寫入對帳單

計算分配損益


