import os, sys
BUFSIZE = 80
MODE = 777
MKFIFO_GETFILE = "/var/www/pipe/innp"
MKFIFO_SENDFILE = "/var/www/pipe/outnp"
TRUE = 1
class FoxBot:

    def __init__(self, system):
        self.system = system
 
    def start(self, input_utt):
        # 辞書型 inputにユーザIDを設定       
        input = {'utt': None, 'sessionId': "myid"}
     
        # システムからの最初の発話をinitial_messageから取得し，送信
        return self.system.initial_message(input)
 
    def message(self, input_utt):
        # 辞書型 inputにユーザからの発話とユーザIDを設定
        input = {'utt': input_utt, 'sessionId': "myid"}
 
        # replyメソッドによりinputから発話を生成
        system_output = self.system.reply(input)
 
        # 発話を送信
        return system_output
 
    def run(self):
      # 名前付きパイプを作成
        get_path = MKFIFO_GETFILE
#        if os.path.exists(get_path) != 1: 
#            os.mkfifo(get_path,0o777)
#
        send_path = MKFIFO_SENDFILE
#        if os.path.exists(send_path) != 1: 
#            os.mkfifo(send_path,0o777)
        

        while True:
            get_fd = os.open(get_path, os.O_RDWR)
            get_word = os.read(get_fd, BUFSIZE).decode('utf-8')
            print(get_word)
            os.close(get_fd)
         
            
            #input_utt = input("YOU:>")
            input_utt = get_word
            if "/start" in input_utt:
                sys_out = self.start(input_utt)
                
                
            else:
                sys_out = self.message(input_utt)
              
            print("SYS:" + sys_out["utt"])
                
            send_fd = os.open(send_path, os.O_RDWR)
            print("move\n")
            os.write(send_fd, sys_out["utt"].encode()+'\0'.encode())
            os.close(send_fd)
            

            if sys_out["end"]:
                break