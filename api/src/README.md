# API.class.php
API抽象类，
# CorpAPI.class.php
为企业开放的接口
# ServiceCorpAPI.class.php
为服务商开放的接口, 使用应用授权的token
# ServiceProviderAPI.class.php
为服务商开放的接口, 使用服务商的token
# 以上API类，都会自动获取、刷新token，调用者不用关心token
