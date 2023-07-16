from onmt.translate.translator import build_translator
import onmt.opts as opts
from onmt.utils.parse import ArgumentParser
import MeCab
#PHPとプロセス間通信するためのBotをインポート
from fox_bot import FoxBot
import re


class GenerativeSystem:
    def __init__(self):
        
        parser = ArgumentParser()
        opts.config_opts(parser)
        opts.translate_opts(parser)
        self.opt = parser.parse_args()
        ArgumentParser.validate_translate_opts(self.opt)
        self.translator = build_translator(self.opt, report_score=True)

        # 単語分割
        self.mecab = MeCab.Tagger("-Owakati")
        self.mecab.parse("")

    def initial_message(self, input):
        return {'utt': 'talk start!', 'end': False}

    def reply(self, input):
        # 単語分割
        src = [self.mecab.parse(input["utt"])[0:-2]]
        # OpenNMT-pyによる返信作成
        scores, predictions = self.translator.translate(
            src=src,
            tgt=None,
            src_dir=self.opt.src_dir,
            batch_size=self.opt.batch_size,
            attn_debug=False
        )
        # 半角スペースを削除
        utt = predictions[0][0].replace(" ", "")
  
        print(utt)
        return {'utt': utt, "end": False}


if __name__ == '__main__':
    system = GenerativeSystem()
    bot = FoxBot(system)
    bot.run()
    